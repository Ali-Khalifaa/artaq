<?php

namespace App\Http\Resources\Api\Student;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentCertificateResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id"  => $this->id,
            "title"       => $this->title."",
            "image"       => $this->image."",
            "created_at"       => $this->created_at->format("Y-m-d H:i")."",
        ];
    }
}
