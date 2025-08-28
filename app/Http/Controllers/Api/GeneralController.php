<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Parent\AuthParentController;
use App\Http\Controllers\Api\Student\AuthStudentController;
use App\Http\Controllers\Api\Teacher\AuthTeacherController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Resources\Api\AyahResource;
use App\Http\Resources\Api\CityResource;
use App\Http\Resources\Api\CountryResource;
use App\Http\Resources\Api\NationalityResource;
use App\Http\Resources\Api\Student\LevelResource;
use App\Http\Resources\Api\Student\MemorizationAmountResource;
use App\Http\Resources\Api\Student\PreservationMethodResource;
use App\Http\Resources\Api\Student\TrackResource;
use App\Http\Resources\Api\SurahResource;
use App\Models\Ayah;
use App\Models\City;
use App\Models\Country;
use App\Models\Level;
use App\Models\MemorizationAmount;
use App\Models\Nationality;
use App\Models\PreservationMethod;
use App\Models\Surah;
use App\Models\Track;

class GeneralController extends Controller
{

    public function login(LoginRequest $request)
    {
        request()->validate(['user_type' => 'required|in:student,teacher,parent']);
        if (request()->user_type == 'student') {
            return app(AuthStudentController::class)->login($request);
        } elseif ($request->user_type == 'teacher') {
            return app(AuthTeacherController::class)->login($request);
        }  elseif (request()->user_type == 'parent') {
            return app(AuthParentController::class)->login($request);
        }
    }



    public function activateAccount()
    {
        request()->validate(['user_type' => 'required|in:student,teacher,parent']);
        if (request()->user_type == 'student') {
            return app(AuthStudentController::class)->activateAccount(request());
        } elseif (request()->user_type == 'teacher') {
            return app(AuthTeacherController::class)->activateAccount(request());
        } elseif (request()->user_type == 'parent') {
            return app(AuthParentController::class)->activateAccount(request());
        }
    }

    public function resendOtp()
    {
        request()->validate(['user_type' => 'required|in:student,teacher,parent']);
        if (request()->user_type == 'student') {
            return app(AuthStudentController::class)->resendOtp(request());
        } elseif (request()->user_type == 'teacher') {
            return app(AuthTeacherController::class)->resendOtp(request());
        } else {
        }
    }

    public function surahs()
    {
        $data = Surah::get();
        return responseJson(SurahResource::collection($data));
    }

    public function ayahs()
    {
        $data = Ayah::whereSurahId(request()->surah_id)->get();
        return responseJson(AyahResource::collection($data));
    }

    public function tracks()
    {
        $data = Track::get();
        return responseJson(TrackResource::collection($data));
    }

    public function preservationMethods()
    {
        $data = PreservationMethod::where(function ($q) {
            if (request()->track_id)
                $q->where('track_id', request()->track_id);
        })->get();
        return responseJson(PreservationMethodResource::collection($data));
    }

    public function levels()
    {
        $data = Level::where(function ($q) {
            if (request()->preservation_method_id)
                $q->where('preservation_method_id', request()->preservation_method_id);
        })->get();
        return responseJson(LevelResource::collection($data));
    }

    public function memorizationAmount()
    {
        $data = MemorizationAmount::get();
        return responseJson(MemorizationAmountResource::collection($data));
    }

    public function nationalities()
    {
        $data = Nationality::get();
        return responseJson(NationalityResource::collection($data));
    }

    public function countries()
    {
        $data = Country::get();
        return responseJson(CountryResource::collection($data));
    }

    public function cities()
    {
        $data = City::where(function ($q) {
            if (request()->country_id)
                $q->where('country_id', request()->country_id);
        })->get();
        return responseJson(CityResource::collection($data));
    }
}
