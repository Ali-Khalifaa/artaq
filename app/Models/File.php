<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class File extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name', 'size', 'url', 'uploaded_by',
        'uploadable_id', 'uploadable_type', 'identifier',"mime_type"
    ];

    public function uploadedBy()
    {
        return $this->belongsTo(Admin::class, 'uploaded_by');
    }

    public function uploadable()
    {
        return $this->morphTo();
    }

    public function getUrlAttribute($value){
        return $value ? asset($value) : asset('assets/images/authentication/logo.png');
    }

}
