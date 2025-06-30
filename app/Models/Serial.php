<?php

namespace App\Models;

use App\Enums\SerialTypesEnum;
use App\Traits\SearchFilterTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Serial extends Model
{
    use HasFactory,SoftDeletes,SearchFilterTrait;

    protected $guarded = ['id'];
    protected $casts = [
        'type' => SerialTypesEnum::class ,
    ];

    protected $table = "serials";
}
