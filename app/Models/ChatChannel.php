<?php

namespace App\Models;

use App\Traits\SearchFilterTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatChannel extends Model
{
    use HasFactory, SoftDeletes,SearchFilterTrait;

    protected $guarded = ['id'];

    protected $table = "chat_channels";

    public function model1()
    {
        return $this->morphTo();
    }

    public function model2()
    {
        return $this->morphTo();
    }


    public function messages()
    {
        return $this->hasMany(ChatMessage::class,'chat_channel_id');
    }

}
