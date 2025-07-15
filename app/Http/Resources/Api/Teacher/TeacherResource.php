<?php

namespace App\Http\Resources\Api\Teacher;

use App\Http\Resources\Dashboard\CityResource;
use App\Http\Resources\Dashboard\CountryResource;
use App\Http\Resources\Dashboard\NationalityResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id"  => $this->id,
            "name"       => $this->name,
            "id_number" => $this->id_number,
            "phone" => $this->phone,
            "gender" => $this->gender,
            "nationality_id" => $this->nationality_id,
            "country_id" => $this->country_id,
            "city_id" => $this->city_id,
            "admin_id" => $this->admin_id,
            "image" => $this->image,
            "status" => $this->status,
            "nationality" => new NationalityResource($this->whenLoaded('nationality')),
            "country" => new CountryResource($this->whenLoaded('country')),
            "city" => new CityResource($this->whenLoaded('city')),
            "created_at" => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('Y-m-d  (H:i)'),
        ];
    }
}
