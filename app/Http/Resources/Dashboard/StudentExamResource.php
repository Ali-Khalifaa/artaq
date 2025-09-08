<?php

namespace App\Http\Resources\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentExamResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id"  => $this->id,
            "student"       => [
                "id" => $this->student?->id,
                "name" => $this->student?->name,
                "email" => $this->student?->email,
                "image" => $this->student?->image,
                "phone" => $this->student?->phone,
                "gender" => $this->student?->gender,
                "code" => $this->student?->code,
                "phone_code" => $this->student?->country?->phone_code,
            ],
            "track" => $this->track,
            "admin_id" => $this->admin?->id,
            "admin" => $this->admin?->name,
            "degree" => $this->degree,
            "exam_link" => $this->link,
            "date_time" => $this->date_time ? Carbon::createFromFormat('Y-m-d H:i:s', $this->date_time)->format('Y-m-d  (H:i)') : '',
             "status" => [
                "status" => $this->status->value,
                "label" => $this->status->translated(),
                "color" => $this->status->color(),
                "icon" => $this->status->icon(),
            ],
            "created_at" => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('Y-m-d  (H:i)'),
        ];
    }
}
