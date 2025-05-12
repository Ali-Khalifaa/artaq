<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Rest\Models\RestDish;

class LanguageTranslation extends Model
{
    use HasFactory;

    protected $table = 'sys_language_translations';

    /**
     * The attributes that are mass assignable.
    */
    protected $fillable = ['model_id' , 'model_type', 'locale','title','description'];

    /**
     * Example
     *  $translations = [
     *      'ar' => [
     *          'title'      => 'arabic title' ,
     *          'description' => 'arabic description' ,
     *      ]
     *  ];
     *  $model->setTranslations($translations);
    */

    public function model(): MorphTo
    {
        return $this->morphTo();
    }

}
