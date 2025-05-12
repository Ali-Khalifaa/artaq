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
            'data'     => $this->data['data'],
            'image'     => $this->data['image'],
            'title'     => is_array($this->data['title']) ? ($this->data['title'][app()->getLocale()] ??  $this->data['title']['ar'])  : __("notifications.".$this->data['title'],$this->data['variables']??[]),
            'message'     => is_array($this->data['message']) ? ($this->data['message'][app()->getLocale()] ??  $this->data['message']['ar'])  : __("notifications.".$this->data['message'],$this->data['variables']??[]),
            'created_at' => $this->data['timeDate'],
            'read_at' => $this->read_at?->format('Y-m-d h:i'),
        ];
    }
}
