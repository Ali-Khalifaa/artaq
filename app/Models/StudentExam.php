<?php

namespace App\Models;

use App\Enums\ExamStatusEnum;
use App\Traits\SearchFilterTrait;
use App\Traits\TranslationsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentExam extends Model
{
    use HasFactory,SoftDeletes , TranslationsTrait,SearchFilterTrait;

    protected $guarded = ['id'];

    protected $table = "student_exams";

    protected $casts = ['status' => ExamStatusEnum::class];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
    public function track()
    {
        return $this->belongsTo(Track::class, 'track_id');
    }

    public function model()
    {
        return $this->morphTo();
    }

}
