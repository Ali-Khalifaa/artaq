<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ChatStoreMessageRequest;
use App\Http\Resources\Api\ChatChannelResource;
use App\Http\Resources\Api\ChatMessageResource;
use App\Models\ChatChannel;
use App\Models\ChatMessage;
use App\Models\Student;
use App\Models\Teacher;
use App\Notifications\MessageNotification;
use Illuminate\Support\Facades\DB;

class ChatChannelController extends Controller
{


    public function getChannels()
    {
        $model = auth()->user();
        $this->searchRequest();
        $channels = ChatChannel::searchAndFilter()->where(function ($q) use ($model) {
            $q->where(function ($q) use ($model) {
                $q->whereModel1Id($model->id)->whereModel1Type(get_class($model));
            })->orWhere(function ($q) use ($model) {
                $q->whereModel2Id($model->id)->whereModel2Type(get_class($model));
            });
        })
            ->rightJoin('chat_messages', 'chat_channels.id', '=', 'chat_messages.chat_channel_id')
            ->select('chat_channels.*', DB::raw('
            COALESCE(MAX(chat_messages.created_at), chat_channels.created_at) as last_message_time
        '))
            ->groupBy('chat_channels.id', 'chat_channels.model1_id', 'chat_channels.model2_id', 'chat_channels.model1_type', 'chat_channels.model2_type', 'chat_channels.created_at', 'chat_channels.deleted_at', 'chat_channels.updated_at') // Group by the channel ID
            ->orderBy('last_message_time', 'desc')
            ->orderBy('chat_channels.created_at', 'desc')
            ->paginate(15);
        return responseJson(ChatChannelResource::collection($channels->items()), '', 200, getPaginates($channels));
    }


    public function getMessages(ChatChannel $chatChannel)
    {
        $model = auth()->user();
        if (
            !(
                ($chatChannel->model1_id == $model->id && $chatChannel->model1_type == get_class($model)) ||
                ($chatChannel->model2_id == $model->id && $chatChannel->model2_type == get_class($model))
            )
        )
            return responseJson(null, "غير مصرح بهذا الامر", 403);
        $chatChannel->messages()->whereReadAt(null)
            ->whereReceiverId(auth()->id())
            ->update(['read_at' => now()]);
        $messages = $chatChannel->messages()->latest()->paginate(30);
        return responseJson(['channel' => new ChatChannelResource($chatChannel), 'messages' => ChatMessageResource::collection(array_reverse($messages->items()))], 'Data exited successfully', 200, getPaginates($messages));
    }


    public function sendMessage(ChatStoreMessageRequest $request)
    {
        $chatChannel = ChatChannel::find(request()->chat_channel_id);

        if (!request()->media && !request()->message)
            return responseJson(null, "يجب ارسال رسالة او وسائط", 422);

        $sender = auth()->user();

        $receiver = $chatChannel->model1_id == $sender->id  && $chatChannel->model1_type == get_class($sender)? $chatChannel->model2 : $chatChannel->model1;

        $chatChannel->messages()->whereReadAt(null)
            ->whereReceiverId(auth()->id())
            ->update(['read_at' => now()]);

        $message = ChatMessage::create([
            'message' => request()->message,
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'sender_type' => get_class($sender),
            'receiver_type' => get_class($receiver),
            'chat_channel_id' => $chatChannel->id,
        ]);
        saveFiles(request()->media, $message, 'general');

        $receiver->notify(new MessageNotification(new ChatMessageResource($message),'message'));

        return responseJson(new ChatMessageResource($message), "تم ارسال الرسالة بنجاح", 200);
    }


    public function createOrGetChannel($modelId)
    {
        $sender = auth()->user();
        $senderId = $sender->id;
        $senderType = get_class($sender);
        $modelType = $senderType == Student::class ? Teacher::class : Student::class;

        // Prevent sending message to self
        if ($senderId == $modelId && $senderType == $modelType) {
            return responseJson(null, "لا يمكنك ارسال الرسالة الى نفسك", 400);
        }

        // Find existing channel between these two models (regardless of order)
        $chatChannel = ChatChannel::where(function ($q) use ($senderId, $senderType, $modelId, $modelType) {
                $q->where('model1_id', $senderId)
                  ->where('model1_type', $senderType)
                  ->where('model2_id', $modelId)
                  ->where('model2_type', $modelType);
            })
            ->orWhere(function ($q) use ($senderId, $senderType, $modelId, $modelType) {
                $q->where('model1_id', $modelId)
                  ->where('model1_type', $modelType)
                  ->where('model2_id', $senderId)
                  ->where('model2_type', $senderType);
            })
            ->first();

        if (!$chatChannel) {
            $chatChannel = ChatChannel::create([
                'model1_id' => $senderId,
                'model1_type' => $senderType,
                'model2_id' => $modelId,
                'model2_type' => $modelType,
            ]);
        }

        return responseJson(new ChatChannelResource($chatChannel));
    }

    protected function searchRequest()
    {
        if ($searchValue = request()->search)
            request()->merge([
                'search' => json_encode([
                    'searchKey' => $searchValue,
                    'searchInTranslations' => false,
                    'columns' => ['chat_channels.id'],
                    'searchInRelations' => [
                        [
                            'relation' => 'model1',
                            'columns' => ['name', 'phone'],
                            'searchInRelationTranslations' => false
                        ],
                        [
                            'relation' => 'model2',
                            'columns' => ['name', 'phone'],
                            'searchInRelationTranslations' => false
                        ],
                        [
                            'relation' => 'messages',
                            'columns' => ['message', 'created_at'],
                            'searchInRelationTranslations' => false
                        ],

                    ]
                ])
            ]);
    }
}
