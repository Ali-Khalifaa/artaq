<?php

namespace App\Models;

use App\Traits\SearchFilterTrait;
use App\Traits\TranslationsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemorizationAmount extends Model
{
    use HasFactory,SoftDeletes , TranslationsTrait,SearchFilterTrait;

    protected $guarded = ['id'];

    protected $table = "memorization_amounts";

    public function students()
    {
        return $this->hasMany(Student::class, 'memorization_amount_id');
    }
}
