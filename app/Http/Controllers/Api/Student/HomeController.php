<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Student\LevelResource;
use App\Http\Resources\Api\Student\MemorizationAmountResource;
use App\Http\Resources\Api\Student\PreservationMethodResource;
use App\Http\Resources\Api\Student\TrackResource;
use App\Models\Level;
use App\Models\MemorizationAmount;
use App\Models\PreservationMethod;
use App\Models\Track;
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

    public function tracks(){
        $data = Track::get();
        return responseJson(TrackResource::collection($data));
    }

    public function preservationMethods(){
        $data = PreservationMethod::where(function($q){
            if(request()->track_id)
                $q->where('track_id',request()->track_id);
        })->get();
        return responseJson(PreservationMethodResource::collection($data));
    }

    public function levels(){
        $data = Level::where(function($q){
            if(request()->preservation_method_id)
                $q->where('preservation_method_id',request()->preservation_method_id);
        })->get();
        return responseJson(LevelResource::collection($data));
    }

    public function memorizationAmount(){
        $data =MemorizationAmount::get();
        return responseJson(MemorizationAmountResource::collection($data));
    }
}
