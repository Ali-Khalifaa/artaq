<?php

namespace App\Http\Resources\Api\Student;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CircleSchedualResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id"  => $this->id,
            "start_time"       => $this->start_time,
            "end_time"       => $this->end_time,
            "day"       => __("messages.".$this->day),
        ];
    }
}
