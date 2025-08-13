<?php

namespace App\Http\Resources\Api\Teacher;

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
            "name"       => $this->name?? $this->phone ,
            "birth_date" => $this->birth_date ? Carbon::parse($this->birth_date)->format('Y-m-d') : "",
            'age' => $this->birth_date ? Carbon::parse($this->birth_date)->age : "",
            "phone" => $this->phone,
            "guardian_phone" => $this->guardian_phone."",
            "gender" => $this->gender."",
            "memorization_amount_id" => $this->memorization_amount_id."",
            "image" => $this->image."",
            "rate" => $this->rate."",
            "number_of_rates" => $this->number_of_rates."",
            "level" => new LevelResource($this->whenLoaded('level')),
            "memorization_type" => new MemorizationAmountResource($this->whenLoaded('memorizationType')),
            "memorization_amount" => new MemorizationAmountResource($this->whenLoaded('memorizationAmount')),
            "nationality" => new NationalityResource($this->whenLoaded('nationality')),
            "country" => new CountryResource($this->whenLoaded('country')),
            "city" => new CityResource($this->whenLoaded('city')),
        ];
    }
}
