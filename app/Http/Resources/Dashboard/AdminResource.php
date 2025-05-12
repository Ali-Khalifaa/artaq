<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{

    public function toArray($request)
    {
        $role = $this->roles()->first();
        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            'status' => $this->status,
            'phone' => $this->phone,
            'image' => $this->image,
            'role_name' => $role?->name ?? null,
        ];
    }
}
