<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Enums\ExamStatusEnum;
use App\Enums\FreeSessionStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Teacher\CircleSessionResource;
use App\Models\CircleDuration;
use App\Models\CircleSession;
use App\Models\CircleSessionStudent;
use App\Models\Level;
use App\Models\Rating;
use App\Models\Student;
use App\Models\StudentExam;
use App\Models\StudentLevelTask;
use App\Models\Teacher;
use App\Models\TeacherCircle;
use App\Notifications\MessageNotification;
use Carbon\Carbon;

class TeacherCircleController extends Controller
{

    public function getNextCircleSessions()
    {
        $teacher = auth('teacher_api')->user();

        $teacherCircles = TeacherCircle::whereTeacherId($teacher->id)->get();

        $circles = [];
        foreach ($teacherCircles as $circle) {
            $nextDay = $this->getNextDay($circle);
            $circles[] =  [
                "id" => $nextDay->circle_id,
                "name" => $circle->circle?->name,
                "no_of_students" => $nextDay->circle->students->count(),
                "date_time" => $nextDay->next_datetime,
                "date_time" => $nextDay->next_datetime,
                "start_time" => $nextDay->start_time,
                "end_time" => $nextDay->end_time,
                "day" => __('messages.' . $nextDay->day),
            ];
        }

        return responseJson($circles);
    }



    private function getNextDay($circle)
    {
        return CircleDuration::whereCircleId($circle->circle_id)->get()
            ->map(function ($item) {
                $dayNumber = Carbon::parse($item->day)->dayOfWeek;
                $nextDate = Carbon::now()->startOfWeek()->addDays($dayNumber)->setTimeFromTimeString($item->start_time);

                $diffInHoursBetweenStartTimeAndEndTime = Carbon::parse($item->end_time)->diffInHours(Carbon::parse($item->start_time));
                if ($nextDate->lessThan(now()->subHours($diffInHoursBetweenStartTimeAndEndTime))) {
                    $nextDate->addWeek();
                }

                $item->next_datetime = $nextDate;
                return $item;
            })
            ->sortBy('next_datetime')
            ->first();
    }

    public function getCircleStudents($circleId)
    {
        $teacher = auth('teacher_api')->user();
        $teacherCircle = TeacherCircle::whereTeacherId($teacher->id)->whereCircleId($circleId)->first();
        if (!$teacherCircle) {
            return responseJson("", "الحلقة غير متاحة", 404);
        }
        $filteredStudents = $teacherCircle->circle->students->map(function ($student) {
            $tasks = StudentLevelTask::whereStudentId($student->id)->whereLevel($student->level_id)->whereStatus(0)->whereRelation("studentCircle", "status", 0)->get();
            if ($tasks->count() > 0 && $student->exams()->whereStatus(ExamStatusEnum::PENDING)->exists()) {
                return $this->getStudentProgress($tasks, $student);
            }
        })->filter(function ($student) {
            return $student != null;
        });
        return responseJson($filteredStudents);
    }

    private function getStudentProgress($tasks, $student)
    {
        $firstTask = $tasks->first();
        // $totalCount = $tasks->count();
        // $completedCount = $tasks->where("status", 1)->count();
        return [
            'id' => $student->id,
            'name' => ($student->name ?? $student->phone) . "",
            'phone' => $student->phone . "",
            'image' => $student->image . "",
            'level' => $student->level?->name . "",
            'preservation_method' => $student->preservationMethod?->name . "",
            "tasme3" => $firstTask?->fromSurah?->name . " ( " . $firstTask?->fromAyah?->text . " )  الى " . $firstTask?->toSurah?->name . " ( " . $firstTask?->toAyah?->text . " ) ",
            "review" => $firstTask?->reviewFromSurah?->name . " ( " . $firstTask?->reviewFromAyah?->text . " )  الى " . $firstTask?->reviewToSurah?->name . " ( " . $firstTask?->reviewToAyah?->text . " ) ",
            // "precentage" => round($completedCount * 100 / $totalCount),
        ];
    }

    public function startCircleSession($circleId)
    {
        $teacher = auth('teacher_api')->user();
        $teacherCircle = TeacherCircle::whereCircleId($circleId)->whereTeacherId($teacher->id)->first();
        if (!$teacherCircle)
            return responseJson("", "الحلقة غير متاحة", 404);

        $nextDay = $this->getNextDay($teacherCircle);
        if (!$nextDay)
            return responseJson("", "لا يوجد جلسات متاحة", 404);

        // check if now not  between next_datetime and now + end_time
        if ($nextDay->next_datetime->isFuture() && $nextDay->next_datetime->greaterThanOrEqualTo(now()->addHours($nextDay->end_time))) {
            return responseJson("", "لا يمكن بدء الجلسة في وقت لاحق", 400);
        }

        if (CircleSession::whereCircleId($nextDay->circle_id)->whereTeacherId($teacher->id)->where('start_time', $nextDay->start_time)->exists()) {
            return responseJson("", "الجلسة لهذه الحلقة في هذا الوقت قد بدأت بالفعل", 400);
        }


        if ($nextDay->next_datetime->isPast()) {
            return responseJson("", "لا يمكن بدء الجلسة في وقت سابق", 400);
        }

        $circleSession = CircleSession::create([
            'circle_id' => $nextDay->circle_id,
            'teacher_id' => $teacher->id,
            'start_time' => $nextDay->start_time,
            'end_time' => $nextDay->end_time,
            'day' => $nextDay->day,
            'date' => now(),
            'status' => FreeSessionStatusEnum::ACTIVE,
        ]);
        $data["channal_name"] = "circle-session";
        $data["channal_id"] = $circleSession->id;
        $data["caller_name"] = $teacher->name ?? $teacher->phone;
        $data["caller_image"] = $teacher->image . "";
        $agoraToken = generateAgoraToken($teacher, $data["channal_name"]);

        $teacherName = $teacher->name ?? $teacher->phone;
        $title = "تم الاتصال بك في مسار الحلقات";
        $message = "قام المعلم {$teacherName}  ببدء الحلقة والاتصال بك للانضمام  الى جلستك داخل مسار الحلقات ";
        sendNotification($teacherCircle->circle->students, [], 'call-student', asset('assets/images/brand-logos/toggle-white.png'), $title, $message);


        $teacherCircle->circle->students->each(function ($student) use ($circleSession, $data) {
            $tasks = StudentLevelTask::whereStudentId($student->id)->whereLevel($student->level_id)->whereStatus(0)->whereRelation("studentCircle", "status", 0)->get();
            if ($tasks->count() > 0 && $student->exams()->whereStatus(ExamStatusEnum::PENDING)->exists()) {
                $firstTask = $tasks->first();
                CircleSessionStudent::create([
                    'circle_session_id' => $circleSession->id,
                    'student_id' => $student->id,
                    'student_level_task_id' => $firstTask->id,
                ]);

                $student->notify(new MessageNotification($data, 'call'));

                // noitification


            } else {
                // if no tasks or exams, we can skip this student
                return;
            }
        });

        return responseJson(['session' => new CircleSessionResource($circleSession), 'agora_token' => $agoraToken], "تم بدء الجلسة بنجاح");
    }

    public function currentCircleSession()
    {
        $teacher = auth('teacher_api')->user();
        $session = CircleSession::whereTeacherId($teacher->id)->whereStatus(FreeSessionStatusEnum::ACTIVE)->first();
        return responseJson(new CircleSessionResource($session));
    }

    public function endCircleSession($id)
    {
        $teacher = auth('teacher_api')->user();
        $session = CircleSession::whereTeacherId($teacher->id)->whereStatus(FreeSessionStatusEnum::ACTIVE)->find($id);
        if (!$session)
            return responseJson("", "لا يوجد جلسة نشطة", 404);

        $session->update([
            'status' => FreeSessionStatusEnum::COMPLETED,
        ]);

        //notification the the circle session is ended
        $teacherName = $teacher->name ?? $teacher->phone;
        $title = "تم انهاء الجلسة";
        $message = "قام المعلم {$teacherName} بانهاء الجلسة الخاصة بك من فضلك قم بتقييم المعلم";
        sendNotification($session->students, [], 'end-session', asset('assets/images/brand-logos/toggle-white.png'), $title, $message);
        return responseJson(new CircleSessionResource($session), __('messages.Updated Successfully'));
    }

    public function cancelCircleSession($id)
    {
        $teacher = auth('teacher_api')->user();
        $session = CircleSession::whereTeacherId($teacher->id)->whereStatus(FreeSessionStatusEnum::ACTIVE)->find($id);
        if (!$session)
            return responseJson("", "لا يوجد جلسة نشطة", 404);

        $session->update([
            'status' => FreeSessionStatusEnum::CANCELED,
        ]);

        //notification cancel circle session
        $teacherName = $teacher->name ?? $teacher->phone;
        $title = "تم الغاء الجلسة";
        $message = "قام المعلم {$teacherName} بالغاء الجلسة الخاصة بك ";
        sendNotification($session->students, [], 'cancel-session', asset('assets/images/brand-logos/toggle-white.png'), $title, $message);

        return responseJson(new CircleSessionResource($session), __('messages.Updated Successfully'));
    }

    public function endCircleSessionStudent($id)
    {
        $teacher = auth('teacher_api')->user();
        request()->validate(['action' => 'required|in:not_attended,passed,failed']);
        $session = CircleSessionStudent::whereNull("attends")->whereRelation("circleSession", "teacher_id", $teacher->id)->find($id);
        if (!$session)
            return responseJson("", "لقد تم انهاء هذه الجلسة للطالب بالفعل", 404);


        $session->update([
            'attends' => request()->action == 'not_attended' ? false : true,
            'is_passed' => request()->action == 'passed' ? true : (request()->action == 'failed' ? false : null),
        ]);

        // add notifications for the different outcomes
        $student = $session->student;
        $teacherName = $teacher->name ?? $teacher->phone;
        $icon = asset('assets/images/brand-logos/toggle-white.png');

        if ($student) {
            if (request()->action == 'not_attended') {
                $title = "لم تحضر الجلسة";
                $message = "لم تحضر الجلسة الخاصة بك مع المعلم {$teacherName} داخل مسار الحلقات.";
                sendNotification([$student], [], 'not-attended', $icon, $title, $message);
            }

            if (request()->action == 'passed') {
                $title = "تم اجتياز المهمة";
                $message = "تهانينا! لقد تم اجتياز مهمتك في الحلقة بواسطة {$teacherName}.";
                sendNotification([$student], [], 'passed-session', $icon, $title, $message);
            }

            if (request()->action == 'failed') {
                $title = "لم تنجح الجلسة";
                $message = "لم يتم اجتياز هذه الجلسة، يرجى المحاولة مرة أخرى مع المعلم {$teacherName}.";
                sendNotification([$student], [], 'failed-session', $icon, $title, $message);
            }
        }

        $studentTask = $session->studentLevelTask;
        if (request()->action == 'passed') {
            $studentTask->update([
                'status' => 1,
            ]);

            $count = StudentLevelTask::whereStudentId($session->student_id)->whereLevel($studentTask->level_id)->whereStatus(0)->count();
            if ($count == 0) {
                $tasks = StudentLevelTask::whereStudentId($session->student_id)->whereLevel($studentTask->level_id)->whereStatus(1)->get();
                $firstTask = $tasks->first();
                $lastTask = $tasks->last();
                $levelName = $studentTask->level?->name ?? "المستوى";
                $exam = StudentExam::create([
                    "name" => "امتحان على $levelName داخل مسار الحلقات والذي يبدأ من " . $firstTask->fromSurah?->name . " ( " . $firstTask->fromAyah?->text . " )  الى " . $lastTask->toSurah?->name . " ( " . $lastTask->toAyah?->text . " ) ",
                    "student_id" => $session->student_id,
                    "track_id" => 2,
                    "model_id" => $studentTask->level_id,
                    "model_type" => Level::class,
                ]);

                $title = "تم إنشاء امتحان";
                $message = "امتحان على $levelName داخل مسار الحلقات والذي يبدأ من " . $firstTask->fromSurah?->name . " ( " . $firstTask->fromAyah?->text . " )  الى " . $lastTask->toSurah?->name . " ( " . $lastTask->toAyah?->text . " ) ";
                sendNotification($student, [], 'exam-created', $icon, $title, $message);
            }
        }

        return responseJson(new CircleSessionResource($session), __('messages.Updated Successfully'));
    }


    public function rateStudent($id)
    {
        request()->validate(['comment' => 'nullable', 'rate' => 'required|integer|in:1,2,3,4,5']);
        $session = CircleSessionStudent::wwhereNotNull("attends")->whereRelation("circleSession", "teacher_id", auth('teacher_api')->id())->find($id);
        if (!$session)
            return responseJson("", "هذه الجلسة لم تنتهي حتى الان", 400);


        if (Rating::whereRatedId($session->student_id)->whereRatedType(Student::class)->whereModelId($session->id)->whereModelType(CircleSessionStudent::class)->exists())
            return responseJson("", __('messages.You already rated this session before'), 404);

        Rating::create([
            "rate" => request()->rate,
            "comment" => request()->comment,
            "rated_id" => $session->student_id,
            "rated_type" => Student::class,
            "model_id" => $session->id,
            "model_type" => CircleSessionStudent::class,
            "ratedby_id" => auth('teacher_api')->id(),
            "ratedby_type" => Teacher::class,
        ]);

        $student = $session->student;
        if ($student)
            $student->update(['rate' => round($student->ratings()->avg('rate'), 1), 'number_of_rates' => $student->number_of_rates + 1]);

        return responseJson("", 'تم التقييم بنجاح');
    }

    public function previousSessions()
    {
        $this->searchForSessionsRequest();
        $teacher = auth('teacher_api')->user();
        $sessions = CircleSession::searchAndFilter()->whereTeacherId($teacher->id)->whereIn("status", [FreeSessionStatusEnum::COMPLETED, FreeSessionStatusEnum::CANCELED])->latest()->paginate(15);
        return responseJson(CircleSessionResource::collection($sessions->items()), '', 200, getPaginates($sessions));
    }


    protected function searchForSessionsRequest()
    {
        if ($searchValue = request()->search)
            request()->merge([
                'search' => json_encode([
                    'searchKey' => $searchValue,
                    'searchInTranslations' => false,
                    'columns' => ['id', 'date', 'start_time', 'end_time', 'day'],
                    'searchInRelations' => [

                        [
                            'relation' => 'circle',
                            'columns' => ['name'],
                            'searchInRelationTranslations' => false
                        ],
                        [
                            'relation' => 'teacher',
                            'columns' => ['name', 'phone'],
                            'searchInRelationTranslations' => false
                        ],
                        [
                            'relation' => 'students',
                            'columns' => ['name', 'phone'],
                            'searchInRelationTranslations' => false
                        ],

                    ]
                ])
            ]);
    }


    public function callStudent($id)
    {
        $teacher = auth("teacher_api")->user();
        $session = CircleSessionStudent::whereRelation("circleSession", function ($q) {
            $q->where('status', FreeSessionStatusEnum::ACTIVE)->where("teacher_id", auth('teacher_api')->id());
        })->find($id);

        if (!$session)
            return responseJson("", "هذه الجلسة لم يأتي موعدها حتى الان او ربما انتهت", 400);
        $agoraToken = generateAgoraToken($teacher, "circle-session-" . $session->circle_session_id);

        $data["channal_id"] = $session->circle_session_id;
        $data["channal_name"] = "circle-session";
        $data["caller_name"] = $teacher->name ?? $teacher->phone;
        $data["caller_image"] = $teacher->image . "";

        $session->student->notify(new MessageNotification($data, 'call'));

        $teacherName = $teacher->name ?? $teacher->phone;
        $title = "تم الاتصال بك في مسار الحلقات";
        $message = "قام المعلم {$teacherName} بالاتصال بك للانضمام  الى جلستك داخل المسار الحلقات ";
        sendNotification($session->student, [], 'call-student', asset('assets/images/brand-logos/toggle-white.png'), $title, $message);

        return responseJson($agoraToken, "جاري الاتصال بالطالب", 200);
    }
}
