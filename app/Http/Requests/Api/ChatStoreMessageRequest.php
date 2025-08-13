<?php

namespace App\Http\Requests\Api;

use App\Models\ChatChannel;
use Illuminate\Foundation\Http\FormRequest;

class ChatStoreMessageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {

        return [
            'message' => 'nullable',
            "media" => "nullable|array",
            "media.*" => "nullable|file|max:15000|mimes:jpeg,png,webp,jpg,gif,mp4,ogx,oga,ogv,ogg,webm,pdf,doc,docx,ppt,pptx,xls,xlsx,txt,zip,rar,7zip",
            'chat_channel_id'   => ['required', 'exists:chat_channels,id', function ($attribute, $value, $fail) {
                $model = auth()->user();
                $chatChannel = ChatChannel::where(function ($q) use ($model) {
                    $q->where(function ($q) use ($model) {
                        $q->whereModel1Id($model->id)->whereModel1Type(get_class($model));
                    })->orWhere(function ($q) use ($model) {
                        $q->whereModel2Id($model->id)->whereModel2Type(get_class($model));
                    });
                })->find($value);
                if (!$chatChannel) {
                    $fail(__('translations.This Channel Doesnt Exist'));
                }
            }],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
