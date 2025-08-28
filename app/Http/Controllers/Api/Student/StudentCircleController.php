<?php

namespace App\Http\Controllers\Api\Student;

use App\Enums\FreeSessionStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Student\CircleSchedualResource;
use App\Http\Resources\Api\Student\StudentLevelTasksResource;
use App\Http\Resources\Api\Student\TeacherResource;
use App\Models\CircleDuration;
use App\Models\CircleSession;
use App\Models\CircleSessionStudent;
use App\Models\Rating;
use App\Models\Student;
use App\Models\StudentCircle;
use App\Models\StudentLevelTask;
use App\Models\Teacher;
use Carbon\Carbon;

class StudentCircleController extends Controller
{
    public function __construct()
    {
        $student = auth('student_api')->user();
        if ($student->track_id != 2)
            return responseJson("", "انت لست في مسار الحلقات", 400);
    }

    public function currentLevelDetails()
    {
        $student = auth('student_api')->user();
        $tasks = StudentLevelTask::whereStudentId($student->id)->whereLevelId($student->level_id)->whereRelation("studentCircle", "status", 0)->get();
        $firstTask = $tasks->first();
        $lastTask = $tasks->last();
        $totalCount = $tasks->count();
        $completedCount = $tasks->where("status", 1)->count();
        return responseJson([
            'level' => $student->level?->name."",
            'preservation_method' => $student->preservationMethod?->name."",
            "manhag" => $firstTask?->fromSurah?->name . " ( " . $firstTask?->fromAyah?->text . " )  الى " . $lastTask?->toSurah?->name . " ( " . $lastTask?->toAyah?->text . " ) ",
            "precentage" => $totalCount == 0 ? 0 : round($completedCount * 100 / $totalCount),
        ]);
    }




    public function getNextSession()
    {
        $student = auth('student_api')->user();

        $studentCircle = StudentCircle::whereStatus(0)->whereStudentId($student->id)->first();
        if(!$studentCircle)
            return responseJson("","لا يوجد حاليا جلسات قادمة",200);
        $nextTask = StudentLevelTask::whereStudentId($student->id)->whereStatus(0)->whereStudentCircleId($studentCircle->id)->first();
        $nextDay = $this->getNextDay($studentCircle);

        $teacher = $studentCircle?->circle?->teachers?->first();
        return responseJson([
            "teacher" => new TeacherResource($teacher),
            "date_time" => $nextDay->next_datetime."",
            "date_time" => $nextDay->next_datetime."",
            "start_time" => $nextDay->start_time."" ,
            "end_time" => $nextDay->end_time ."",
            "day" => __('messages.'.$nextDay->day) ,
            "manhag" => $nextTask?->fromSurah?->name . " ( " . $nextTask?->fromAyah?->text . " )  الى " . $nextTask?->toSurah?->name . " ( " . $nextTask?->toAyah?->text . " ) ",
            "review" => $nextTask?->reviewFromSurah?->name . " ( " . $nextTask?->reviewFromAyah?->text . " )  الى " . $nextTask?->reviewToSurah?->name . " ( " . $nextTask?->reviewToAyah?->text . " ) ",
        ]);
    }

    public function currentCircleSession(){
        $student = auth('student_api')->user();
        $circleSession = CircleSession::whereStatus(FreeSessionStatusEnum::ACTIVE)->whereRelation("students", "student_id", $student->id)->first();
        if (!$circleSession)
            return responseJson("", "لا يوجد جلسة نشطة", 404);

        $circleSession->load(['circle', 'teacher', 'students']);
    }



    private function getNextDay($studentCircle)
    {
        return CircleDuration::whereCircleId($studentCircle->circle_id)->get()
            ->map(function ($item) {
                // determine numeric day index (0 = Sunday, 6 = Saturday)
                $dayNumber = null;

                // if day is already numeric
                if (is_numeric($item->day)) {
                    $dayNumber = intval($item->day);
                } else {
                    // try parsing common English weekday names
                    try {
                        $dayNumber = Carbon::parse($item->day)->dayOfWeek;
                    } catch (\Exception $e) {
                        $dayNumber = null;
                    }

                    // fallback: common Arabic weekday names mapping
                    if ($dayNumber === null) {
                        $arabicDays = [
                            'الأحد' => 0,
                            'الاثنين' => 1,
                            'الثلاثاء' => 2,
                            'الأربعاء' => 3,
                            'الخميس' => 4,
                            'الجمعة' => 5,
                            'السبت' => 6,
                        ];
                        $normalized = trim($item->day);
                        $dayNumber = $arabicDays[$normalized] ?? null;
                    }
                }

                // final fallback to today's weekday if nothing matched
                if ($dayNumber === null) {
                    $dayNumber = Carbon::now()->dayOfWeek;
                }

                // compute next date for that weekday and set start time
                $now = Carbon::now();
                $todayWeekday = $now->dayOfWeek;
                $daysToAdd = ($dayNumber - $todayWeekday + 7) % 7;
                $nextDate = $now->copy()->startOfDay()->addDays($daysToAdd)->setTimeFromTimeString($item->start_time);

                // compute end datetime for that occurrence
                $endDate = $nextDate->copy()->setTimeFromTimeString($item->end_time);

                // if the end datetime has already passed, move to next week's occurrence
                if ($endDate->lessThanOrEqualTo($now)) {
                    $nextDate->addWeek();
                }

                $item->next_datetime = $nextDate;
                return $item;
            })
            ->sortBy('next_datetime')
            ->first();
    }

    public function getCircleSchedual(){
        $student = auth('student_api')->user();
        $studentCircle = StudentCircle::whereStatus(0)->whereStudentId($student->id)->first();
        if(!$studentCircle)
            return responseJson("","لا يوجد حاليا جلسات قادمة",200);
        $circles = CircleDuration::whereCircleId($studentCircle->circle_id)->get();
        return responseJson(CircleSchedualResource::collection($circles));
    }



    public function previousSessions()
    {
        $this->searchForSessionsRequest();
        $student = auth('student_api')->user();
        $tasks = StudentLevelTask::searchAndFilter()->whereStudentId($student->id)->whereStatus(1)->latest()->paginate(15);
        return responseJson(StudentLevelTasksResource::collection($tasks->items()), '', 200, getPaginates($tasks));
    }



    protected function searchForSessionsRequest()
    {
        if ($searchValue = request()->search)
            request()->merge([
                'search' => json_encode([
                    'searchKey' => $searchValue,
                    'searchInTranslations' => false,
                    'columns' => ['id'],
                    'searchInRelations' => [
                        [
                            'relation' => 'circle.teacher',
                            'columns' => ['name', 'phone'],
                            'searchInRelationTranslations' => false
                        ],
                        [
                            'relation' => 'circle',
                            'columns' => ['name'],
                            'searchInRelationTranslations' => false
                        ],
                        [
                            'relation' => 'level',
                            'columns' => ['name'],
                            'searchInRelationTranslations' => false
                        ],
                        [
                            'relation' => 'fromSurah',
                            'columns' => ['surahs.name'],
                            'searchInRelationTranslations' => false
                        ],
                        [
                            'relation' => 'toSurah',
                            'columns' => ['surahs.name'],
                            'searchInRelationTranslations' => false
                        ],
                        [
                            'relation' => 'fromAyah',
                            'columns' => ['ayahs.text'],
                            'searchInRelationTranslations' => false
                        ],
                        [
                            'relation' => 'toAyah',
                            'columns' => ['ayahs.text'],
                            'searchInRelationTranslations' => false
                        ],
                        [
                            'relation' => 'reviewFromSurah',
                            'columns' => ['surahs.name'],
                            'searchInRelationTranslations' => false
                        ],
                        [
                            'relation' => 'reviewToSurah',
                            'columns' => ['surahs.name'],
                            'searchInRelationTranslations' => false
                        ],
                        [
                            'relation' => 'reviewFromAyah',
                            'columns' => ['ayahs.text'],
                            'searchInRelationTranslations' => false
                        ],
                        [
                            'relation' => 'reviewToAyah',
                            'columns' => ['ayahs.text'],
                            'searchInRelationTranslations' => false
                        ],

                    ]
                ])
            ]);
    }


    public function rateTeacher($id)
    {
        request()->validate(['comment' => 'nullable', 'rate' => 'required|integer|in:1,2,3,4,5']);
        $session = StudentLevelTask::whereStatus(1)->where("student_id", auth('student_api')->id())->find($id);
        if (!$session)
            return responseJson("", "هذه الجلسة لم تنتهي حتى الان", 400);

        $teacher = $session->circle?->teacher;

        // if (Rating::whereRatedId($teacher->id)->whereRatedType(Teacher::class)->whereModelId($session->id)->whereModelType(IntensiveSession::class)->exists())
        //     return responseJson("", __('messages.You already rated this session before'), 404);

        Rating::updateOrCreate([
        ],[
            "rate" => request()->rate,
            "comment" => request()->comment,
            "rated_id" => $teacher->id,
            "rated_type" => Teacher::class,
            "model_id" => $session->id,
            "model_type" => StudentLevelTask::class,
            "rateby_id" => auth('student_api')->id(),
            "rateby_type" => Student::class,
        ]);

        if ($teacher)
            $teacher->update(['rate' => round($teacher->ratings()->avg('rate'), 1), 'number_of_rates' => $teacher->number_of_rates + 1]);

        return responseJson("", 'تم التقييم بنجاح');
    }


    public function acceptCall()
    {
        $student = auth("student_api")->user();
        $currentSession = CircleSessionStudent::whereStudentId(auth('student_api')->id())->find(request()->channel_id);
        if (!$currentSession)
            return responseJson("","هذه الجلسة ليست موجودة", 404);
        $agoraToken = generateAgoraToken($student, "circle-session-" . $currentSession->id);
        return responseJson($agoraToken);
    }
}
