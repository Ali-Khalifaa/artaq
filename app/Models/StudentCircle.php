<?php

namespace App\Models;

use App\Traits\SearchFilterTrait;
use App\Traits\TranslationsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentCircle extends Model
{
    use HasFactory,SoftDeletes , TranslationsTrait,SearchFilterTrait;

    protected $guarded = ['id'];

    protected $table = "student_circles";

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function circle()
    {
        return $this->belongsTo(Circle::class, 'circle_id');
    }

}
