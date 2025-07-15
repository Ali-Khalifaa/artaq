<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CityResource;
use App\Http\Resources\Api\CountryResource;
use App\Http\Resources\Api\NationalityResource;
use App\Models\City;
use App\Models\Country;
use App\Models\Nationality;

class GeneralController extends Controller
{

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
