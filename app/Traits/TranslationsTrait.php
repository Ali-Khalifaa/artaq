<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use App\Models\LanguageTranslation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait TranslationsTrait{

    public function translations(): MorphMany
    {
        return $this->morphMany(LanguageTranslation::class, 'model');
    }

    public function translation(): MorphOne
    {
        $locale = request()->header('Accept-Language') ?? app()->getLocale();
        return $this->morphOne(LanguageTranslation::class, 'model')->where('locale' ,  $locale);
    }

    // current_translation
    public function getCurrentTranslationAttribute()
    {
        return $this->translation ?? $this->translations->first();
    }

    public function translate($locale = null)
    {
        $locale = $locale ?? request()->header('Accept-Language') ?? app()->getLocale();
        return $this->translations->where('locale' , $locale);
    }

    function setTranslationsAttribute($translations = []) {
    }

    function setTranslations($translations = []) {

        $this->translations()->delete();

        foreach ($translations as $locale => $translation) {
            if(!@$translation['title']){
                continue;
            }
            $this->translations()->create($translation + ['locale' => $locale]);
        }

    }
}
