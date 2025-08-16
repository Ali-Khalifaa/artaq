<?php

namespace App\Http\Controllers\Api\Student;

use App\Enums\RequestActionEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Student\IntensiveRequestResource;
use App\Http\Resources\Api\Student\IntensiveSessionResource;
use App\Http\Resources\Api\Student\TeacherResource;
use App\Models\FreeSession;
use App\Models\IntensiveRequest;
use App\Models\IntensiveSession;
use App\Models\IntensiveStudy;
use App\Models\PreservationMethod;
use App\Models\Rating;
use App\Models\Student;
use App\Models\Teacher;

class IntensiveSessionsController extends Controller
{
    public function sendSessionRequest($teacherId)
    {
        $student = auth('student_api')->user();
        $teacher = Teacher::whereStatus(true)->find($teacherId);
        if (!$teacher || $teacher->intensiveRequests()->whereStatus(RequestActionEnum::ACCEPT)->count() >= 7)
            return responseJson("", __('messages.This teacher is not available right now'), 404);

        if (IntensiveRequest::whereStatus(RequestActionEnum::ACCEPT)->whereStudentId(auth('student_api')->id())->exists())
            return responseJson("", "انت بالفعل بداخل مسار مكثف من فضلك قم بأنهائه اولا", 404);

        if (IntensiveRequest::whereStudentId($student->id)->whereStatus(RequestActionEnum::WAITING)->count())
            return responseJson("", "لديك طلب انضمام لمسار المكثف مع معلم بالفعل", 400);

        if ($student->track_id != 3)
            return responseJson("", "يجب ان تكون بداخل المسار المكثف", 400);

        if (!$student->preservation_method_id || !PreservationMethod::whereTrackId(3)->find($student->preservation_method_id))
            return responseJson("", "يجب اختيار اتجاه الحفظ التابع للمسار المكثف", 400);

        $freeSession = IntensiveRequest::create([
            'teacher_id' => $teacher->id,
            'student_id' => $student->id,
            'preservation_method_id' => $student->preservation_method_id,
            'status' => RequestActionEnum::WAITING,
        ]);

        $studentName = $student->name ?? $student->phone;
        $title = "لديك طلب انضمام جديد داخل المسار المكثف";
        $message = " لديك طلب انضمام جديد في المسار المكثف من الطالب {$studentName} واتجاه الحفظ هو {$freeSession->preservationMethod->name}";
        sendNotification($teacher, [],'send-intensive-request',asset('assets/images/brand-logos/toggle-white.png'),$title,$message);

        return responseJson(new IntensiveRequestResource($freeSession), '', 200);
    }


    public function getCurrentIntensiveRquest()
    {
        $currentSession = IntensiveRequest::whereIn("status", [RequestActionEnum::WAITING, RequestActionEnum::ACCEPT])->whereStudentId(auth('student_api')->id())->first();
        return responseJson($currentSession ? new IntensiveRequestResource($currentSession) : '');
    }

    public function getActiveTeachers()
    {
        $this->searchForTeachersRequest();
        $teachers = Teacher::searchAndFilter()
            ->whereStatus(true)
            ->whereHas('intensiveRequests', function ($query) {
                $query->where('status', RequestActionEnum::ACCEPT);
            }, '<', 7)
            ->paginate(20);
        return responseJson(TeacherResource::collection($teachers->items()), '', 200, getPaginates($teachers));
    }


    public function previousSessions()
    {
        $this->searchForSessionsRequest();
        $sessions = IntensiveSession::searchAndFilter()->whereStatus(1)->whereRelation("intensiveStudy.intensiveRequest","student_id",auth("student_api")->id())->latest()->paginate(10);
        return responseJson(IntensiveSessionResource::collection($sessions->items()), '', 200, getPaginates($sessions));
    }

    public function nextSession()
    {
        $nextSession = IntensiveSession::whereStatus(0)->whereRelation("intensiveStudy.intensiveRequest","student_id",auth("student_api")->id())->latest()->first();
        return responseJson($nextSession ? new IntensiveSessionResource($nextSession) : "");
    }

    public function lastSessionDetails()
    {
        $lastSession = IntensiveSession::whereStatus(1)->whereRelation("intensiveStudy.intensiveRequest","student_id",auth("student_api")->id())->latest()->first();
        return responseJson($lastSession ? new IntensiveSessionResource($lastSession) : "");
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
                            'relation' => 'intensiveStudy.intensiveRequest.teacher',
                            'columns' => ['name', 'phone'],
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
        $session = IntensiveSession::whereStatus(1)->whereRelation("intensiveStudy.intensiveRequest", "student_id", auth('student_api')->id())->find($id);
        if (!$session)
            return responseJson("", "هذه الجلسة لم تنتهي حتى الان", 400);

        $teacher = $session->intensiveStudy?->intensiveRequest?->teacher;

        if (Rating::whereRatedId($teacher->id)->whereRatedType(Teacher::class)->whereModelId($session->id)->whereModelType(IntensiveSession::class)->exists())
            return responseJson("", __('messages.You already rated this session before'), 404);

        Rating::create([
            "rate" => request()->rate,
            "comment" => request()->comment,
            "rated_id" => $teacher->id,
            "rated_type" => Teacher::class,
            "model_id" => $session->id,
            "model_type" => IntensiveSession::class,
            "ratedby_id" => auth('student_api')->id(),
            "ratedby_type" => Student::class,
        ]);

        if ($teacher)
            $teacher->update(['rate' => round($teacher->ratings()->avg('rate'), 1), 'number_of_rates' => $teacher->number_of_rates + 1]);

        return responseJson("", 'تم التقييم بنجاح');
    }


    // public function acceptCall($channelName)
    // {
    //     $student = auth("student_api")->user();
    //     $agoraToken = generateAgoraToken($student, $channelName);
    //     return responseJson($agoraToken);
    // }

    public function acceptCall()
    {
        $student = auth("student_api")->user();
        $session = IntensiveSession::whereStatus(0)->whereRelation("intensiveStudy.intensiveRequest", "student_id", auth('student_api')->id())->find(request()->channel_id);
        if (!$session)
            return responseJson("", "هذه الجلسة غير موجود او ربما انتهت", 400);
        $agoraToken = generateAgoraToken($student, "intensive-session-" . $session->id);
        return responseJson($agoraToken);
    }
}
