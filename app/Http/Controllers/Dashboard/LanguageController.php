<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\LanguageRequest;
use App\Http\Resources\Dashboard\LanguageResource;
use Illuminate\Http\Request;
use App\Interfaces\LanguageInterface;
use App\Models\Language;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class LanguageController extends Controller implements HasMiddleware
{
    protected $interface;
    public function __construct(LanguageInterface $interface)
    {
        $this->interface = $interface;
    }

    public static function middleware(): array
    {
        // return [];
        return [
            new Middleware('can:language read', only: ['index']),
            new Middleware('can:language create', only: ['store']),
            new Middleware('can:language edit', only: ['update', 'show']),
            new Middleware('can:language delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
    */
    public function index(Request $request)
    {
        // $languages = $this->interface->all(filter:$request->all() , paginate:10);

        $languages = Language::searchAndFilter()->latest()->paginate(10);

        return responseJson(LanguageResource::collection($languages->items()),'Languages',200,getPaginates($languages));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LanguageRequest $request)
    {
        $this->interface->store($request->validated());
        return responseJson([],'Created Successfully',200);
    }

    /**
     * Show the specified resource.
     */

     public function show($id)
     {
         $language = Language::with('translations')->findOrFail($id);
         return responseJson($language,'Data exited successfully',200);
     }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LanguageRequest $request, Language $language)
    {
        $data = $request->validated();
        if($request->hasFile('flag')){
            unlink_image_by_path($language->flag);
        }
        $language->update($data);
        $language->setTranslations($request->translations);
        return responseJson(new LanguageResource($language),'Updated Successfully',200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $deleted = $this->interface->delete($id);
        if(!$deleted){
            return responseJson(null,'Cannot Delete',400);
        }
        return responseJson([],'Deleted Successfully',200);
    }
}
