<?php

namespace App\Http\Resources\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowStudentResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id"  => $this->id,
            "name"       => $this->name,
            "email"       => $this->email,
            "code"       => $this->code,
            "birth_date" => $this->birth_date ? Carbon::parse($this->birth_date)->format('Y-m-d') : null,
            'age' => $this->birth_date ? Carbon::parse($this->birth_date)->age : null,
            "level_id" => $this->level_id,
            "phone" => $this->phone,
            "guardian" => $this->guardian,
            "guardian_phone" => $this->guardian_phone,
            "id_number" => $this->id_number,
            "juz_count" => $this->juz_count,
            "preservation_method_id" => $this->preservation_method_id,
            "track_id" => $this->track_id,
            "gender" => $this->gender,
            "nationality_id" => $this->nationality_id,
            "country_id" => $this->country_id,
            "city_id" => $this->city_id,
            "memorization_amount_id" => $this->memorization_amount_id,
            "image" => $this->image,
            "status" => $this->status,
            "track" => new TrackResource($this->whenLoaded('track')),
            "level" => new LevelResource($this->whenLoaded('level')),
            "preservation_method" => new MemorizationAmountResource($this->whenLoaded('preservationMethod')),
            "memorization_amount" => new MemorizationAmountResource($this->whenLoaded('memorizationAmount')),
            "nationality" => new NationalityResource($this->whenLoaded('nationality')),
            "country" => new CountryResource($this->whenLoaded('country')),
            "city" => new CityResource($this->whenLoaded('city')),
            "circles" => CircleResource::collection(
                $this->whenLoaded('circles')->load('circleType', 'teachers')
            ),
            "certificates" => CertificateResource::collection($this->whenLoaded('certificates')),
            "digitalBadges" => DigitalBadgeResource::collection($this->whenLoaded('digitalBadges')),
            "exams" => StudentExamResource::collection($this->whenLoaded('exams')->load('track', 'admin')),
            "created_at" => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('Y-m-d  (H:i)'),
        ];
    }
}
