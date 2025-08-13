<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatMessageResource extends JsonResource
{

    public function toArray($request)
    {
        $media = $this->media;
        return [
            "id" => $this->id,
            "message" => $this->message,
            "chat_channel_id" => $this->chat_channel_id,
            "media" => $media->pluck('url')->toArray(),
            "mime_type" => $media->pluck('mime_type')->toArray(),
            "sender" => [
                "id" => $this->sender_id,
                "name" => $this->sender?->name ?? $this->sender?->phone,
                "image" => $this->sender?->image ?? asset('assets/images/authentication/logo.png'),
            ],
            "time" => $this->created_at->format('H:i a'),
            "date" => $this->created_at->format('Y-m-d'),
            "read_at" => $this->read_at?->format('Y-m-d H:i')??'',
        ];
    }
}
