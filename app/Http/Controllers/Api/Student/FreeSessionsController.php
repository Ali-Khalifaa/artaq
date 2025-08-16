<?php

namespace App\Http\Controllers\Api\Student;

use App\Enums\FreeSessionStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Student\FreeSessionResource;
use App\Http\Resources\Api\Student\TeacherResource;
use App\Models\FreeSession;
use App\Models\Rating;
use App\Models\Student;
use App\Models\Teacher;

class FreeSessionsController extends Controller
{
    public function startSession($teacherId)
    {
        $student = auth('student_api')->user();
        $teacher = Teacher::whereWorkStatus(true)->whereStatus(true)->whereDoesntHave("freeSessions",function($q){
            $q->where("status",FreeSessionStatusEnum::ACTIVE);
        })->find($teacherId);
        if (!$teacher)
            return responseJson("", __('messages.This teacher is not available right now'), 404);

        if (FreeSession::whereStatus(FreeSessionStatusEnum::ACTIVE)->whereStudentId(auth('student_api')->id())->exists())
            return responseJson("", __('messages.You already have an active session wait till your teacher end it and rate you'), 404);

        if (FreeSession::whereStudentId($student->id)->whereStatus(FreeSessionStatusEnum::PENDING)->count())
            return responseJson("", __('messages.You already have a session request'), 400);

        $freeSessionsCount = FreeSession::whereStudentId($student->id)->whereStatus(FreeSessionStatusEnum::COMPLETED)->count();
        if (($freeSessionsCount == 5 &&  !$student->track_id)  || in_array($student->track_id, [2, 3] ))
            return responseJson("", "لقد قمت بأستخدام الخمس جلسات المجانية والان انت لست في المسار الحر او صحيح التلاوة", 400);

        $freeSession = FreeSession::create([
            'teacher_id' => $teacher->id,
            'student_id' => $student->id,
            'status' => FreeSessionStatusEnum::PENDING
        ]);
        $studentName = $student->name ?? $student->phone;

        sendNotification($teacher, [],'send-session-request',asset('assets/images/brand-logos/toggle-white.png'),"لديك طلب جلسة جديد في المسار الحر", "لديك طلب جلسة جديد في المسار الحر من الطالب {$studentName}");

        return responseJson(new FreeSessionResource($freeSession), '', 200);
    }

    public function getAllTeachers()
    {
        $this->searchForTeachersRequest();
        $teachers = Teacher::searchAndFilter()->whereStatus(true)->paginate(20);
        return responseJson(TeacherResource::collection($teachers->items()), '', 200, getPaginates($teachers));
    }

    public function getCurrentSession()
    {
        $currentSession = FreeSession::whereStatus(FreeSessionStatusEnum::ACTIVE)->whereStudentId(auth('student_api')->id())->first();
        return responseJson($currentSession?new FreeSessionResource($currentSession):'');
    }

    public function acceptCall()
    {
        $student = auth("student_api")->user();
        $currentSession = FreeSession::whereStatus(FreeSessionStatusEnum::ACTIVE)->whereStudentId(auth('student_api')->id())->find(request()->channel_id);
        if (!$currentSession)
            return responseJson("","هذه الجلسة ليست موجودة", 404);
        $agoraToken = generateAgoraToken($student,"free-session-".$currentSession->id);
        return responseJson($agoraToken);
    }

    public function getActiveTeachers()
    {
        $this->searchForTeachersRequest();
        $teachers = Teacher::searchAndFilter()->whereDoesntHave("freeSessions",function($q){
            $q->where("status",FreeSessionStatusEnum::ACTIVE);
        })->whereWorkStatus(true)->whereStatus(true)->paginate(20);
        return responseJson(TeacherResource::collection($teachers->items()), '', 200, getPaginates($teachers));
    }

    public function freeSessionsDetails()
    {
        $teachersCount = Teacher::whereWorkStatus(true)->whereStatus(true)->count();
        $freeSessionsCount = FreeSession::whereIn('status', [FreeSessionStatusEnum::ACTIVE, FreeSessionStatusEnum::COMPLETED])->whereStudentId(auth("student_api")->id())->count();
        $sessionMinute = 20;
        return responseJson(['active_teachers_count' => $teachersCount, 'free_sessions_count' => $freeSessionsCount, 'session_minutes' => $sessionMinute]);
    }

    public function previousSessions()
    {
        $this->searchForSessionsRequest();
        $sessions = FreeSession::whereIn('status',[FreeSessionStatusEnum::COMPLETED,FreeSessionStatusEnum::CANCELED,FreeSessionStatusEnum::ACTIVE])->whereStudentId(auth("student_api")->id())->latest()->paginate(10);
        return responseJson(FreeSessionResource::collection($sessions->items()),'',200,getPaginates($sessions));
    }

    public function lastSessionDetails()
    {
        $lastSession = FreeSession::where('status',FreeSessionStatusEnum::COMPLETED)->whereStudentId(auth("student_api")->id())->latest()->first();
        return responseJson($lastSession ? new FreeSessionResource($lastSession) : "" );
    }


    protected function searchForTeachersRequest()
    {
        if ($searchValue = request()->search)
            request()->merge([
                'search' => json_encode([
                    'searchKey' => $searchValue,
                    'searchInTranslations' => false,
                    'columns' => ['name', 'phone'],
                    'searchInRelations' => [
                        [
                            'relation' => 'nationality',
                            'columns' => ['nationalities.id'],
                            'searchInRelationTranslations' => true
                        ],
                        [
                            'relation' => 'city',
                            'columns' => ['cities.id'],
                            'searchInRelationTranslations' => true
                        ],
                        [
                            'relation' => 'country',
                            'columns' => ['countries.id'],
                            'searchInRelationTranslations' => true
                        ],

                    ]
                ])
            ]);
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
                            'relation' => 'teacher',
                            'columns' => ['name','phone'],
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

                    ]
                ])
            ]);
    }


    public function rateTeacher($id)
    {
        request()->validate(['comment' => 'nullable', 'rate' => 'required|integer|in:1,2,3,4,5']);
        $freeSession = FreeSession::whereStatus(FreeSessionStatusEnum::COMPLETED)->whereStudentId(auth('student_api')->id())->find($id);
        if (!$freeSession)
            return responseJson("", __('messages.not_found'), 404);
        if (Rating::whereRatedId($freeSession->teacher_id)->whereRatedType(Teacher::class)->whereModelId($freeSession->id)->whereModelType(FreeSession::class)->exists())
            return responseJson("", __('messages.You already rated this session before'), 404);

        Rating::create([
            "rate" => request()->rate,
            "comment" => request()->comment,
            "rated_id" => $freeSession->teacher_id,
            "rated_type" => Teacher::class,
            "model_id" => $freeSession->id,
            "model_type" => FreeSession::class,
            "ratedby_id" => auth('student_api')->id(),
            "ratedby_type" => Student::class,
        ]);

        $teacher = Teacher::find($freeSession->teacher_id);

        if($teacher)
            $teacher->update(['rate' => round($teacher->ratings()->avg('rate'),1),'number_of_rates' => $teacher->number_of_rates + 1 ]);


        return responseJson("", 'تم التقييم بنجاح');
    }
}
