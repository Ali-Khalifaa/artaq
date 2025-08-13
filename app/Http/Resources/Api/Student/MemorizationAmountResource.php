<?php

namespace App\Http\Resources\Api\Student;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class MemorizationAmountResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id"  => $this->id,
            "name"       => $this->name,
        ];
    }
}
