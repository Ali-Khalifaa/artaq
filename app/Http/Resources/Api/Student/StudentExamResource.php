<?php

namespace App\Http\Resources\Api\Student;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentExamResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id"  => $this->id,
            "name"       => $this->name,
            "degree"       => $this->degree . "",
            "link"       => $this->link."",
            "date_time"       => $this->date_time."",
            "track"       => $this->track?->name . "",
            'status' => [
                'name' => $this->status->translated(),
                'value' => $this->status->value,
                'color' => $this->status->colorCode(),
            ],
        ];
    }
}
