<?php

namespace App\Models;

use App\Traits\SearchFilterTrait;
use App\Traits\TranslationsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DigitalBadge extends Model
{
    use HasFactory,SoftDeletes , TranslationsTrait,SearchFilterTrait;

    protected $guarded = ['id'];

    protected $table = "digital_badges";

    protected $casts = ['created_at' => "datetime"];

    public function getImageAttribute($value): string
    {
        return asset('upload/general/'.$value);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function students(){
        return $this->belongsToMany(Student::class,'student_digital_badges','digital_badge_id','student_id','id','id')->withTimestamps();
    }
}
