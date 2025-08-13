<?php

namespace App\Models;

use App\Enums\FreeSessionStatusEnum;
use App\Traits\SearchFilterTrait;
use App\Traits\TranslationsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CircleSession extends Model
{
    use HasFactory,SoftDeletes , TranslationsTrait,SearchFilterTrait;

    protected $guarded = ['id'];

    protected $table = "circle_sessions";

    protected $casts = ['status' => FreeSessionStatusEnum::class];


    public function circle()
    {
        return $this->belongsTo(Circle::class)->withTrashed();
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class)->withTrashed();
    }

    public function students(){
        return $this->belongsToMany(Student::class, 'circle_session_students', 'circle_session_id', 'student_id')
            ->withPivot('attends', 'student_level_task_id')
            ->using(CircleSessionStudent::class)
            ->withTimestamps();
    }

    public function circleSessionStudents()
    {
        return $this->hasMany(CircleSessionStudent::class, 'circle_session_id');
    }

}
