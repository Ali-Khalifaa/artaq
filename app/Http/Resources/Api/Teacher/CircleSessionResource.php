<?php

namespace App\Http\Resources\Api\Teacher;


use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CircleSessionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id"  => $this->id,
            'status' => [
                'name' => $this->status->translated(),
                'value' => $this->status->value,
                'color' => $this->status->colorCode(),
            ],
            "students" => CircleSessionStudentResource::collection($this->circleSessionStudents),
            "circle" => $this->circle?->name."",
            "date" => $this->date."",
            "start_time" => $this->start_time."",
            "end_time" => $this->end_time."",
            "day" => $this->day."",
            "created_at" => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('Y-m-d  (H:i)'),
        ];
    }

}
