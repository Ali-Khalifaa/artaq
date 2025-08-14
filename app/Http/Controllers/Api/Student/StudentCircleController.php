<?php

namespace App\Http\Controllers\Api\Student;

use App\Enums\FreeSessionStatusEnum;
use App\Enums\RequestActionEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Student\CircleSchedualResource;
use App\Http\Resources\Api\Student\IntensiveRequestResource;
use App\Http\Resources\Api\Student\StudentLevelTasksResource;
use App\Http\Resources\Api\Student\TeacherResource;
use App\Models\CircleDuration;
use App\Models\CircleSession;
use App\Models\FreeSession;
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
        $tasks = StudentLevelTask::whereStudentId($student->id)->whereLevel($student->level_id)->whereRelation("studentCircle", "status", 0)->get();
        $firstTask = $tasks->first();
        $lastTask = $tasks->last();
        $totalCount = $tasks->count();
        $completedCount = $tasks->where("status", 1)->count();
        return responseJson([
            'level' => $student->level?->name."",
            'preservation_method' => $student->preservationMethod?->name."",
            "manhag" => $firstTask?->fromSurah?->name . " ( " . $firstTask?->fromAyah?->text . " )  الى " . $lastTask?->toSurah?->name . " ( " . $lastTask?->toAyah?->text . " ) ",
            "precentage" => round($completedCount * 100 / $totalCount),
        ]);
    }




    public function getNextSession()
    {
        $student = auth('student_api')->user();

        $studentCircle = StudentCircle::whereStatus(0)->whereStudentId($student->id)->first();
        $nextTask = StudentLevelTask::whereStudentId($student->id)->whereStatus(0)->whereStudentCircleId($studentCircle->id)->first();
        $nextDay = $this->getNextDay($studentCircle);

        $teacher = $studentCircle->circle->teachers->first();
        return [
            "teacher" => new TeacherResource($teacher),
            "date_time" => $nextDay->next_datetime."",
            "date_time" => $nextDay->next_datetime."",
            "start_time" => $nextDay->start_time."" ,
            "end_time" => $nextDay->end_time ."",
            "day" => __('messages.'.$nextDay->day) ,
            "manhag" => $nextTask?->fromSurah?->name . " ( " . $nextTask?->fromAyah?->text . " )  الى " . $nextTask?->toSurah?->name . " ( " . $nextTask?->toAyah?->text . " ) ",
            "review" => $nextTask?->reviewFromSurah?->name . " ( " . $nextTask?->reviewFromAyah?->text . " )  الى " . $nextTask?->reviewToSurah?->name . " ( " . $nextTask?->reviewToAyah?->text . " ) ",
        ];
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

    public function getCirclerSchedual(){
        $student = auth('student_api')->user();
        $studentCircle = StudentCircle::whereStatus(0)->whereStudentId($student->id)->first();
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
            "ratedby_id" => auth('student_api')->id(),
            "ratedby_type" => Student::class,
        ]);

        if ($teacher)
            $teacher->update(['rate' => round($teacher->ratings()->avg('rate'), 1), 'number_of_rates' => $teacher->number_of_rates + 1]);

        return responseJson("", 'تم التقييم بنجاح');
    }


    public function acceptCall()
    {
        $student = auth("student_api")->user();
        $currentSession = FreeSession::whereStatus(RequestActionEnum::ACTIVE)->whereStudentId(auth('student_api')->id())->first();
        $agoraToken = generateAgoraToken($student, "session-" . $currentSession->id);
        return responseJson(["session" => new IntensiveRequestResource($currentSession), "agora_token" => $agoraToken]);
    }
}
