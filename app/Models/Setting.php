<?php

namespace App\Models;

use App\Traits\SearchFilterTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory,SearchFilterTrait,SearchFilterTrait;

    protected $table ="settings";
    protected $guarded = ['id'];
}
