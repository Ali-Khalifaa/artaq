<?php

namespace App\Http\Resources\Api\Teacher;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class DigitalBadgesResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id"  => $this->id,
            "name"       => $this->name."",
            "description"       => $this->description . "",
            "image"       => $this->image."",
            "created_at"       => $this->created_at->format("Y-m-d H:i")."",
        ];
    }
}
