<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;

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



}
