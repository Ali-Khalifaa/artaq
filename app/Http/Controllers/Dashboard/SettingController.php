<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\SettingRequest;
use App\Http\Resources\Dashboard\LanguageResource;
use App\Http\Resources\Dashboard\SettingResource;
use App\Models\Language;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class SettingController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        // return [];
        return [
            new Middleware('can:setting read', only: ['index']),
            new Middleware('can:setting edit',only:['update']),
        ];
    }

    public function getLanguage()
    {
        $languages = Language::where('status',1)->with('translations')->get();
        return responseJson(LanguageResource::collection($languages),__('messages.application_languages'),200);
    }


    public function index(Request $request)
    {
        $joinUs = Setting::searchAndFilter()->latest()->paginate(10);

        return responseJson(SettingResource::collection($joinUs->items()), 'joinUs', 200, getPaginates($joinUs));
    }

    public function show($id)
    {
        $JoinUs = Setting::findOrFail($id);
        return responseJson($JoinUs, 'Updated Successfully', 200);
    }

    public function update(SettingRequest $request,$id){
        $data =$request->validated();
        $joinUs = Setting::find($id);
        $joinUs->update($data);
        return responseJson(new SettingResource($joinUs),'Updated Successfully', 200);
    }
}
