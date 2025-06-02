<?php

namespace App\Models;

use App\Traits\SearchFilterTrait;
use App\Traits\TranslationsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeacherQualification extends Model
{
    use HasFactory,SoftDeletes , TranslationsTrait,SearchFilterTrait;

    protected $guarded = ['id'];

    protected $table = "teacher_qualifications";

    public function getImageAttribute($value): string
    {
        return asset('upload/general/'.$value);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
}
