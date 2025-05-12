<?php

namespace App\Models;

use App\Traits\SearchFilterTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JoinUs extends Model
{
    use HasFactory,SearchFilterTrait,SearchFilterTrait;

    protected $table ="join_us";
    protected $guarded = ['id'];
}
