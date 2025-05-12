<?php

namespace App\Models;

use App\Traits\SearchFilterTrait;
use App\Traits\TranslationsTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
{
    use HasFactory , SoftDeletes , TranslationsTrait, SearchFilterTrait;

    protected $table = 'sys_languages';

    /**
     * The attributes that are mass assignable.
    */
    protected $guarded = ['id'];
    protected $fillable = ['flag', 'code','status'];

    protected $appends = ['image'];

    // image
    public function getImageAttribute(): string
    {
        return $this->flag ? asset('upload/general/' .$this->flag) : default_image('language');
    }

    protected function flag(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value,
            set: fn ($value) => store_single_image($value , 'languages'),
        );
    }

}
