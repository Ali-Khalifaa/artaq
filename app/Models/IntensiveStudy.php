<?php

namespace App\Models;

use App\Enums\FreeSessionStatusEnum;
use App\Enums\RequestActionEnum;
use App\Traits\SearchFilterTrait;
use App\Traits\TranslationsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IntensiveStudy extends Model
{
    use HasFactory, SoftDeletes, TranslationsTrait, SearchFilterTrait;

    protected $guarded = ['id'];

    protected $table = "intensive_studies";


    public function intensiveRequest()
    {
        return $this->belongsTo(IntensiveRequest::class, 'intensive_request_id');
    }

    public function intensiveSessions()
    {
        return $this->hasMany(IntensiveSession::class, 'intensive_study_id');
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
