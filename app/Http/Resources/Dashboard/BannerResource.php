<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "image" => $this->image.'',
            "position" => $this->position,
            "status" => $this->status,
            "created_at" => $this->created_at,
        ];
    }
}
