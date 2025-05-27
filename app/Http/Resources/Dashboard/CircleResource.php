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
            "gender" => $this->gender,
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
