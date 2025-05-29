<?php

namespace App\Models;

use App\Traits\SearchFilterTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PreservationMethod extends Model
{
    use HasFactory,SearchFilterTrait,SoftDeletes;

    protected $guarded = ['id'];

    protected $table = "preservation_methods";

    public function students()
    {
        return $this->hasMany(Student::class, 'preservation_method_id');
    }

}
