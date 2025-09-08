<?php

namespace App\Models;

use App\Traits\SearchFilterTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Certificate extends Model
{
    use HasFactory,SoftDeletes,SearchFilterTrait;

    protected $guarded = ['id'];

    protected $table = "certificates";

    protected $casts = ['created_at' => "datetime"];

    public function getImageAttribute($value): string
    {
        return asset('upload/general/'.$value);
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

}
