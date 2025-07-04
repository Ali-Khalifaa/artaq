<?php

namespace App\Http\Resources\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CircleResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id"  => $this->id,
            "name"       => $this->name,
            "circle_type_id" => $this->circle_type_id,
            "circle_type" => new CircleTypeResource($this->whenLoaded('circleType')),
            "teacher_name" => $this->whenLoaded('teachers', function () {
                return $this->teachers()->first() ? $this->teachers()->first()->name : null;
            }),
            "gender" => $this->gender,
            "end_time" => $this->end_time,
            "start_time" => $this->start_time,
            "status" => $this->status,
            "duration" => $this->circleDurations->map(function ($duration) {
                return [
                    'day' => $duration->day,
                    'start_time' => $duration->start_time,
                    'end_time' => $duration->end_time,
                ];
            }),
            "created_at" => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('Y-m-d  (H:i)'),
        ];
    }
}
