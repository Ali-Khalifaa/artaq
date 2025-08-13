<?php

namespace App\Http\Resources\Api\Student;

use App\Http\Resources\Dashboard\CityResource;
use App\Http\Resources\Dashboard\CountryResource;
use App\Http\Resources\Dashboard\LevelResource;
use App\Http\Resources\Dashboard\MemorizationAmountResource;
use App\Http\Resources\Dashboard\NationalityResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id"  => $this->id,
            "name"       =>  $this->name??$this->phone,
            "birth_date" => $this->birth_date ? Carbon::parse($this->birth_date)->format('Y-m-d') : "",
            'age' => $this->birth_date ? Carbon::parse($this->birth_date)->age : "",
            "track" => $this->track?->name."",
            "level" => $this->level ? [
                'name' => $this->level?->name."",
                'description' => $this->level?->description."",
            ] : "",
            "preservation_method" => $this->preservationMethod ? $this->preservationMethod?->name."" : "",
            "track_id" => $this->track_id."",
            "level_id" => $this->level_id."",
            "preservation_method_id" => $this->preservation_method_id."",
            "phone" => $this->phone,
            "guardian_phone" => $this->guardian_phone."",
            "memorization_type_id" => $this->memorization_type_id."",
            "gender" => $this->gender."",
            "nationality_id" => $this->nationality_id."",
            "country_id" => $this->country_id."",
            "city_id" => $this->city_id."",
            "memorization_amount_id" => $this->memorization_amount_id."",
            "image" => $this->image."",
            "status" => $this->status."",
            "rate" => $this->rate."",
            "number_of_rates" => $this->number_of_rates."",
            "memorization_type" => $this->memorizationType ? new MemorizationAmountResource($this->memorizationType):"",
            "memorization_amount" => $this->memorizationAmount ? new MemorizationAmountResource($this->memorizationAmount) : "",
            "nationality" =>$this->nationality? new NationalityResource($this->nationality):"",
            "country" => $this->country ? new CountryResource($this->country):"",
            "city" =>  $this->city? new CityResource($this->city):"",
        ];
    }
}
