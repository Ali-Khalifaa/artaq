<?php

namespace App\Models;

use App\Enums\FreeSessionStatusEnum;
use App\Traits\SearchFilterTrait;
use App\Traits\TranslationsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CircleSessionStudent extends Model
{
    use HasFactory,SoftDeletes , TranslationsTrait,SearchFilterTrait;

    protected $guarded = ['id'];

    protected $table = "circle_session_students";

    protected $casts = ['status' => FreeSessionStatusEnum::class];

    public function circleSession()
    {
        return $this->belongsTo(CircleSession::class)->withTrashed();
    }

    public function student()
    {
        return $this->belongsTo(Student::class)->withTrashed();
    }

    public function studentLevelTask()
    {
        return $this->belongsTo(StudentLevelTask::class)->withTrashed();
    }

}
