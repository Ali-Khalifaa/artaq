<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LanguageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"          => $this->id,
            "code"        => $this->code,
            "title"       => $this->current_translation?->title,
            "description" => $this->current_translation?->description,
            "image"        => $this->image,
            "status"      => $this->status,
            "created_at"  => $this->created_at,
        ];
    }
}
