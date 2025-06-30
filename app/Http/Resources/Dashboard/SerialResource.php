<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class SerialResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "type" => [
                "name" => $this->type->name,
                "value" => $this->type->value,
                "label" => $this->type->label(),
            ],
            "prefix"=> $this->prefix,
            "start_number" => $this->start_number,
            "created_at" => $this->created_at->format('Y-m-d H:i'),
        ];
    }
}
