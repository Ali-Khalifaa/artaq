<?php

namespace App\Http\Resources\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowTeacherResource extends JsonResource
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
            "admin" => $this->whenLoaded('admin'),
            "nationality" => new NationalityResource($this->whenLoaded('nationality')),
            "country" => new CountryResource($this->whenLoaded('country')),
            "city" => new CityResource($this->whenLoaded('city')),
            "circles" => CircleResource::collection(
                $this->whenLoaded('circles')->load('circleType')
            ),
            "juz_count" => $this->juz_count,
            "experience_years" => $this->experience_years,
            "Quran_licenses" => $this->Quran_licenses,
            "salary" => $this->salary,
            "cv" => $this->cv,
            "birth_date" => $this->birth_date ? Carbon::parse($this->birth_date)->format('Y-m-d') : null,
            'age' => $this->birth_date ? Carbon::parse($this->birth_date)->age : null,
            "email" => $this->email,
            "created_at" => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('Y-m-d  (H:i)'),
        ];
    }
}
