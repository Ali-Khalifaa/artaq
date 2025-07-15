<?php

namespace App\Http\Resources\Api\Student;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class LevelResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id"  => $this->id,
            "name"       => $this->name,
            "preservation_method_id" => $this->preservation_method_id,
            "preservation_method" => new PreservationMethodResource($this->whenLoaded('preservationMethod')),
            "description"       => $this->description,
        ];
    }
}
