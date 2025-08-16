<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Class\AgoraDynamicKey\RtcTokenBuilder;
use App\Enums\FreeSessionStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SurahAndAyahRequest;
use App\Http\Resources\Api\Teacher\FreeSessionResource;
use App\Models\FreeSession;
use App\Models\Rating;
use App\Models\Student;
use App\Models\Teacher;
use App\Notifications\MessageNotification;

class FreeSessionsController extends Controller
{


    public function getFreeSessionRequests()
    {
        $freeSessions = FreeSession::whereStatus(FreeSessionStatusEnum::PENDING)->whereTeacherId(auth('teacher_api')->id())->get();
        return responseJson(FreeSessionResource::collection($freeSessions));
    }

    public function getCurrentSession()
    {
        $currentSession = FreeSession::whereStatus(FreeSessionStatusEnum::ACTIVE)->whereTeacherId(auth('teacher_api')->id())->first();
        return responseJson($currentSession ? new FreeSessionResource($currentSession):'');
    }

    public function acceptSessionRequest($id){

        $teacher = auth("teacher_api")->user();
        $freeSession = FreeSession::whereStatus(FreeSessionStatusEnum::PENDING)->whereTeacherId(auth('teacher_api')->id())->find($id);
        if(!$freeSession)
            return responseJson("",__('messages.not_found'),400);
        if (FreeSession::whereStatus(FreeSessionStatusEnum::ACTIVE)->whereTeacherId(auth('teacher_api')->id())->exists())
            return responseJson("", __('messages.You already have an active session end it and rate the student'), 400);

        $freeSession->update(['status' => FreeSessionStatusEnum::ACTIVE]);

        $agoraToken = generateAgoraToken($teacher,"free-session-".$freeSession->id);

        $data["channal_name"] = "free-session";
        $data["channal_id"] = $freeSession->id;
        $data["caller_name"] = $teacher->name ?? $teacher->phone;
        $data["caller_image"] = $teacher->image."";

        $freeSession->student->notify(new MessageNotification($data,'call'));

        $teacherName = $teacher->name ?? $teacher->phone;
        $title = "تم الموفقة على طلب الجلسة";
        $message = "قام المعلم {$teacherName} بالموافقة على طلبك الانضمام الى جلسة المسار الحر {$freeSession->student->name}";
        sendNotification($freeSession->student, [],'accept-session',asset('assets/images/brand-logos/toggle-white.png'),$title,$message);
        return responseJson(["session" => new FreeSessionResource($freeSession),'agora_token' => $agoraToken],__('messages.Updated Successfully'));
    }


    public function endSession(SurahAndAyahRequest $request,$id){
        $freeSession = FreeSession::whereStatus(FreeSessionStatusEnum::ACTIVE)->whereTeacherId(auth('teacher_api')->id())->find($id);
        if(!$freeSession)
            return responseJson("",__('messages.not_found'),404);

        $teacher = auth("teacher_api")->user();


        $freeSession->update([
            'status' => FreeSessionStatusEnum::COMPLETED,
            "from_surah_id" => request()->from_surah_id,
            "to_surah_id" => request()->to_surah_id,
            "from_ayah_id" => request()->from_ayah_id,
            "to_ayah_id" => request()->to_ayah_id,
        ]);

        $teacherName = $teacher->name ?? $teacher->phone;
        $title = "تم الانتهاء من الجلسة";
        $message = "قام المعلم  $teacherName بانهاء الجلسة الخاصة بك من فضلك قم بتقييم المعلم";
        sendNotification($freeSession->student, [],'end-session',asset('assets/images/brand-logos/toggle-white.png'),$title,$message);

        return responseJson(new FreeSessionResource($freeSession),__('messages.Updated Successfully'));
    }


    public function rateStudent($id){
        request()->validate(['comment' => 'nullable','rate' => 'required|integer|in:1,2,3,4,5']);
        $freeSession = FreeSession::whereStatus(FreeSessionStatusEnum::COMPLETED)->whereTeacherId(auth('teacher_api')->id())->find($id);
        if(!$freeSession)
            return responseJson("",__('messages.not_found'),404);
        if(Rating::whereRatedId($freeSession->student_id)->whereRatedType(Student::class)->whereModelId($freeSession->id)->whereModelType(FreeSession::class)->exists())
            return responseJson("",__('messages.You already rated this session before'),404);

        Rating::create([
            "rate" => request()->rate,
            "comment" => request()->comment,
            "rated_id" => $freeSession->student_id,
            "rated_type" => Student::class,
            "model_id" => $freeSession->id,
            "model_type" => FreeSession::class,
            "ratedby_id" => auth('teacher_api')->id(),
            "ratedby_type" => Teacher::class,
        ]);

         $student = Student::find($freeSession->student_id);

        if($student)
            $student->update(['rate' => round($student->ratings()->avg('rate'),1),'number_of_rates' => $student->number_of_rates + 1 ]);


        return responseJson("",'تم التقييم بنجاح');
    }


}
