<?php

namespace App\Models;

use App\Enums\FreeSessionStatusEnum;
use App\Enums\RequestActionEnum;
use App\Traits\SearchFilterTrait;
use App\Traits\TranslationsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IntensiveRequest extends Model
{
    use HasFactory,SoftDeletes , TranslationsTrait,SearchFilterTrait;

    protected $guarded = ['id'];

    protected $table = "intensive_requests";

    protected $casts = ['status' => RequestActionEnum::class];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function preservationMethod()
    {
        return $this->belongsTo(PreservationMethod::class, 'preservation_method_id');
    }

    public function intensiveStudies()
    {
        return $this->hasMany(IntensiveStudy::class, 'intensive_request_id');
    }


}
