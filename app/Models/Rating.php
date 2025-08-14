<?php

namespace App\Models;

use App\Enums\FreeSessionStatusEnum;
use App\Traits\SearchFilterTrait;
use App\Traits\TranslationsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rating extends Model
{
    use HasFactory,SoftDeletes , TranslationsTrait,SearchFilterTrait;

    protected $guarded = ['id'];

    protected $table = "ratings";

    // Relations

    // The entity that was rated
    public function rated()
    {
        return $this->morphTo();
    }

    // The entity that performed the rating
    public function rateby()
    {
        return $this->morphTo();
    }

    // The model that the rating is about
    public function model()
    {
        return $this->morphTo();
    }
}
