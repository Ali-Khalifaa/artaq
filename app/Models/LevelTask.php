<?php

namespace App\Models;

use App\Traits\SearchFilterTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LevelTask extends Model
{
    use HasFactory,SearchFilterTrait,SoftDeletes;

    protected $guarded = ['id'];

    protected $table = "level_tasks";

    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id');
    }

    public function fromSurah()
    {
        return $this->belongsTo(Surah::class, 'from_surah_id');
    }

    public function toSurah()
    {
        return $this->belongsTo(Surah::class, 'to_surah_id');
    }

    public function fromAyah()
    {
        return $this->belongsTo(Ayah::class, 'from_ayah_id');
    }

    public function toAyah()
    {
        return $this->belongsTo(Ayah::class, 'to_ayah_id');
    }

    public function reviewFromSurah()
    {
        return $this->belongsTo(Surah::class, 'review_from_surah_id');
    }
    
    public function reviewToSurah()
    {
        return $this->belongsTo(Surah::class, 'review_to_surah_id');
    }

    public function reviewFromAyah()
    {
        return $this->belongsTo(Ayah::class, 'review_from_ayah_id');
    }

    public function reviewToAyah()
    {
        return $this->belongsTo(Ayah::class, 'review_to_ayah_id');
    }

}
