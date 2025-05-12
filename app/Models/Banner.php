<?php

namespace App\Models;

use App\Traits\SearchFilterTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use HasFactory,SoftDeletes,SearchFilterTrait;

    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d ( H:i )',
        'updated_at' => 'datetime:Y-m-d ( H:i )' ,
        'status' => 'boolean' ,
    ];
    protected $table = "banners";

    public function getImageAttribute($value): string
    {
        return asset('upload/general/'.$value);
    }

}
