<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ShowAdminResource extends JsonResource
{

    public function toArray($request)
    {
        $role = $this->roles()->first();
        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            'status' => $this->status,
            'phone' => $this->phone,
            'image' => $this->image,
            'role_name' => $role?->name ?? null,
            "id_number" => $this->id_number,
            "gender" => $this->gender,
            "nationality" => new NationalityResource($this->whenLoaded('nationality')),
            "country" => new CountryResource($this->whenLoaded('country')),
            "city" => new CityResource($this->whenLoaded('city')),
            "juz_count" => $this->juz_count,
            "experience_years" => $this->experience_years,
            "Quran_licenses" => $this->Quran_licenses,
            "salary" => $this->salary,
            "birth_date" => $this->birth_date ? Carbon::parse($this->birth_date)->format('Y-m-d') : null,
            'age' => $this->birth_date ? Carbon::parse($this->birth_date)->age : null,
            "teachers" => ShowTeacherResource::collection($this->whenLoaded('teachers')->load('city','country','nationality')),
            "circles" => $this->whenLoaded('teachers', function () {
                return $this->teachers->load('circles.teachers')->pluck('circles')->flatten()->unique('id')->values()->map(function ($circle) {
                    return new CircleResource($circle);
                });
            }),
            "created_at" => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('Y-m-d  (H:i)'),
        ];
    }
}
