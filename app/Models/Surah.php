<?php

namespace App\Models;

use App\Traits\SearchFilterTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surah extends Model
{
    use HasFactory,SearchFilterTrait;

    protected $guarded = ['id'];

    protected $table = "surahs";

    public function ayahs()
    {
        return $this->hasMany(Ayah::class, 'surah_id');
    }

}
