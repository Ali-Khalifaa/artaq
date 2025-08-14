<?php

namespace App\Http\Resources\Api\Student;

use App\Http\Resources\Api\CityResource;
use App\Http\Resources\Api\CountryResource;
use App\Http\Resources\Api\NationalityResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id"  => $this->id,
            "name"       => $this->name."",
            "phone" => $this->phone."",
            "image" => $this->image."",
            "nationality" => new NationalityResource($this->whenLoaded('nationality')),
            "country" => new CountryResource($this->whenLoaded('country')),
            "city" => new CityResource($this->whenLoaded('city')),
            "juz_count" => $this->juz_count."",
            "experience_years" => $this->experience_years."",
            "rate" => $this->rate."",
            "number_of_rates" => $this->number_of_rates."",
            // "qualifications" => $this->qualifications,
            'age' => $this->birth_date ? Carbon::parse($this->birth_date)->age : "",
        ];
    }
}
