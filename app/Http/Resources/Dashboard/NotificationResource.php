<?php

namespace App\Http\Resources\Dashboard;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            // 'data'     => $this->data['data'],
            'image'     => $this->data['image']."",
            'title'     => $this->data['title']."",
            'message'     => $this->data['message']."",
            'created_at' => $this->data['timeDate'],
            'read_at' => $this->read_at?->format('Y-m-d h:i'),
        ];
    }
}
