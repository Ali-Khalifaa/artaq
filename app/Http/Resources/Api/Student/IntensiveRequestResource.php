<?php

namespace App\Http\Resources\Api\Student;

use App\Http\Resources\Api\Student\TeacherResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class IntensiveRequestResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id"  => $this->id,
            "teacher"       => new TeacherResource($this->teacher),
            'status' => [
                'name' => $this->status->label(),
                'value' => $this->status->value,
            ],
            "time" => $this->time."",
            "preservation_method" => $this->preservationMethod?->name."",
            "created_at" => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('Y-m-d  (H:i)'),
        ];
    }
}
