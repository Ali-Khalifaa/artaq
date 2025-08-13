<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatMessage extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $table = "chat_messages";

    protected $casts = ["read_at" => 'datetime'];

    public function sender()
    {
        return $this->morphTo();
    }

    public function receiver()
    {
        return $this->morphTo();
    }

    public function channel()
    {
        return $this->belongsTo(ChatChannel::class,'chat_channel_id');
    }

    public function media()
    {
        return $this->morphMany(File::class, 'uploadable')->whereNull('identifier');
    }
}
