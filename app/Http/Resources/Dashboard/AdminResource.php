<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class AdminResource extends JsonResource
{

    public function toArray($request)
    {
        $role = $this->roles()->first();
        return [
            "id" => $this->id,
            "code" => $this->code,
            "name" => $this->name,
            "email" => $this->email,
            'status' => $this->status,
            'phone' => $this->phone,
            'image' => $this->image,
            'role_name' => $role?->name ?? null,
            "id_number" => $this->id_number,
            "gender" => $this->gender,
            "nationality_id" => $this->nationality_id,
            "country_id" => $this->country_id,
            "city_id" => $this->city_id,
            "nationality" => new NationalityResource($this->whenLoaded('nationality')),
            "country" => new CountryResource($this->whenLoaded('country')),
            "city" => new CityResource($this->whenLoaded('city')),
            "juz_count" => $this->juz_count,
            "experience_years" => $this->experience_years,
            "Quran_licenses" => $this->Quran_licenses,
            "salary" => $this->salary,
            "birth_date" => $this->birth_date ? Carbon::parse($this->birth_date)->format('Y-m-d') : null,
            'age' => $this->birth_date ? Carbon::parse($this->birth_date)->age : null,
            "created_at" => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('Y-m-d  (H:i)'),
        ];
    }
}
