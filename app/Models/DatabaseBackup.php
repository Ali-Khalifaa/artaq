<?php

namespace App\Models;

use App\Traits\SearchFilterTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DatabaseBackup extends Model
{
    use HasFactory , SoftDeletes ,SearchFilterTrait;

    protected $guarded = ['id'];
    protected $table = 'database_backup';

    public function getFullPathAttribute()
    {
        return asset('upload/database/' . env('APP_NAME') . '/' . $this->path);
    }


}
