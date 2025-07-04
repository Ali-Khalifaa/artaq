<?php

namespace App\Models;

use App\Traits\SearchFilterTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Level extends Model
{
    use HasFactory,SearchFilterTrait,SoftDeletes;

    protected $guarded = ['id'];

    protected $table = "levels";

    public function preservationMethod()
    {
        return $this->belongsTo(PreservationMethod::class, 'preservation_method_id');
    }

     public function digitalBadges()
    {
        return $this->hasMany(DigitalBadge::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'level_id');
    }
    
    public function levelTasks()
    {
        return $this->hasMany(LevelTask::class, 'level_id');
    }
}
