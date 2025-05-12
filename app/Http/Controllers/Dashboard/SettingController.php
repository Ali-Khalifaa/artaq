<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\LanguageResource;
use App\Models\Language;

class SettingController extends Controller
{
    public function getLanguage()
    {
        $languages = Language::where('status',1)->with('translations')->get();
        return responseJson(LanguageResource::collection($languages),__('messages.application_languages'),200);
    }
}
