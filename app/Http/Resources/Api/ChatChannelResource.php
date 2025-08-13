<?php

namespace App\Http\Resources\Api;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatChannelResource extends JsonResource
{

    public function toArray($request)
    {
        $model = auth()->user();

        $receiver = $this->model1_id == $model->id && $this->model1_type == get_class($model) ? $this->model2()->withTrashed()->first() : $this->model1()->withTrashed()->first();

        $lastMessage = $this->messages()->latest()->first();
        return [
            "id" => $this->id,
            "receiver" => [
                "id" => $receiver->id,
                "name" => $receiver->name??$receiver->phone,
                'image' => $receiver->media?->url ?? asset('assets/images/authentication/logo.png'),
            ],
            "last_message" => $lastMessage ? new ChatMessageResource($lastMessage) : null,
            "created_at" => $this->created_at->format('jS \of F  h:i'),
            "unread_messages" => $this->messages()->whereReadAt(null)->whereReceiverId($model->id)->whereReceiverType(get_class($model))->count(),
        ];
    }
}
