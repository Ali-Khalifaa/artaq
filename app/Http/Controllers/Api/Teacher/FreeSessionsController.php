<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Enums\FreeSessionStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Teacher\FreeSessionResource;
use App\Models\FreeSession;
use App\Models\Rating;
use App\Models\Student;
use App\Models\Teacher;

class FreeSessionsController extends Controller
{


    public function getFreeSessionRequests()
    {
        $freeSessions = FreeSession::whereStatus(FreeSessionStatusEnum::PENDING)->whereTeacherId(auth('teacher_api')->id())->get();
        return responseJson(FreeSessionResource::collection($freeSessions));
    }

    public function acceptSessionRequest($id){
        $freeSession = FreeSession::whereStatus(FreeSessionStatusEnum::PENDING)->whereTeacherId(auth('teacher_api')->id())->find($id);
        if(!$freeSession)
            return responseJson(null,__('messages.not_found'),404);

        $freeSession->update(['status' => FreeSessionStatusEnum::APPROVED]);

        return responseJson(new FreeSessionResource($freeSession),__('messages.Updated Successfully'));

    }


    public function endSession($id){
        $freeSession = FreeSession::whereStatus(FreeSessionStatusEnum::APPROVED)->whereTeacherId(auth('teacher_api')->id())->find($id);
        if(!$freeSession)
            return responseJson(null,__('messages.not_found'),404);

        $freeSession->update([
            'status' => FreeSessionStatusEnum::COMPLETED,
            "from_surah_id" => request()->from_surah_id,
            "to_surah_id" => request()->to_surah_id,
            "from_ayah_id" => request()->from_ayah_id,
            "to_ayah_id" => request()->to_ayah_id,
        ]);

        return responseJson(new FreeSessionResource($freeSession),__('messages.Updated Successfully'));
    }


    public function rateStudent($id){
        request()->validate(['comment' => 'nullable','rate' => 'required|integer|in:1,2,3,4,5']);
        $freeSession = FreeSession::whereStatus(FreeSessionStatusEnum::COMPLETED)->whereTeacherId(auth('teacher_api')->id())->find($id);
        if(!$freeSession)
            return responseJson(null,__('messages.not_found'),404);
        if(Rating::whereRatedId($freeSession->student_id)->whereRatedType(Student::class)->whereModelId($freeSession->id)->whereModelType(FreeSession::class)->exists())
            return responseJson(null,__('messages.You already rated this session before'),404);

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


        return responseJson(null,'تم التقييم بنجاح');
    }


}
