<?php

namespace App\Models;

use App\Enums\FreeSessionStatusEnum;
use App\Traits\SearchFilterTrait;
use App\Traits\TranslationsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IntensiveSession extends Model
{
    use HasFactory,SoftDeletes , TranslationsTrait,SearchFilterTrait;

    protected $guarded = ['id'];

    protected $table = "intensive_sessions";


    public function intensiveStudy()
    {
        return $this->belongsTo(IntensiveStudy::class, 'intensive_study_id');
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

}
