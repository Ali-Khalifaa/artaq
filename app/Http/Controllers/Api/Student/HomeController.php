<?php

namespace App\Http\Controllers\Api\Student;

use App\Enums\ExamStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Student\DigitalBadgesResource;
use App\Http\Resources\Api\Student\StudentCertificateResource;
use App\Http\Resources\Api\Student\StudentExamResource;
use App\Models\Certificate;
use App\Models\DigitalBadge;
use App\Models\StudentExam;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class HomeController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth:student_api'),
        ];
    }

    public function acceptCall(){
        request()->validate(['channel_name' => 'required|string|in:free-session,intensive-session,circle-session',"channel_id" => 'required|integer']);
        if(request()->channel_name == "free-session"){
            return app(FreeSessionsController::class)->acceptCall();
        }elseif(request()->channel_name == "intensive-session"){
            return app(IntensiveSessionsController::class)->acceptCall();
        }elseif(request()->channel_name == "circle-session"){
            return app(StudentCircleController::class)->acceptCall();
        }

    }

    public function getNextExam(){
        $student = auth("student_api")->user();
        $exam = StudentExam::whereStatus(ExamStatusEnum::PENDING)->whereStudentId($student->id)->first();
        return responseJson($exam ? new StudentExamResource($exam):"");
    }

    public function getPrevExams(){
        $student = auth("student_api")->user();
        $exams = StudentExam::where("status","!=",ExamStatusEnum::PENDING)->whereStudentId($student->id)->get();
        return responseJson(StudentExamResource::collection($exams));
    }

    public function digitalBadges(){
        $student = auth("student_api")->user();
        $digitalBadges = DigitalBadge::whereStudentId($student->id)->get();
        return responseJson(DigitalBadgesResource::collection($digitalBadges));
    }

    public function certificates(){
        $student = auth("student_api")->user();
        $Certificates = Certificate::whereStudentId($student->id)->get();
        return responseJson(StudentCertificateResource::collection($Certificates));
    }



}
