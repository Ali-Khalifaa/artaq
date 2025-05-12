<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CountryRequest;
use App\Http\Resources\Dashboard\CountryResource;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CountryController extends Controller implements HasMiddleware
{


    public static function middleware(): array
    {
        return [
            new Middleware('can:country read', only: ['index']),
            new Middleware('can:country create', only: ['store']),
            new Middleware('can:country edit', only: ['update', 'show']),
            new Middleware('can:country delete', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        $banners = Country::searchAndFilter()->latest()->paginate(10);

        return responseJson(CountryResource::collection($banners->items()),'',200,getPaginates($banners));
    }



    public function store(CountryRequest $request)
    {

        $data = $request->validated();
        $data['image'] = store_single_image($request->image);
        Country::create($data);
        return responseJson([],'Created Successfully',200);
    }


    public function show($id)
    {
        $category = Country::with('translations')->find($id);
        return responseJson($category,'Data exited successfully',200);
    }

    public function update(CountryRequest $request, Country $country)
    {
        $data = $request->validated();
        if($request->hasFile('image')){
            unlink_image_by_path($country->getAttributes()['image']);
            $data['image'] = store_single_image($request->image);
        }
        $country->update($data);
        return responseJson($country,'Updated Successfully',200);
    }

    public function destroy(Country $country)
    {
        unlink_image_by_path($country->getAttributes()['image']);
        $country->delete();
        return responseJson([],'Deleted Successfully',200);
    }

    public function dropdown()
    {
        $countries = Country::all();

        return responseJson(CountryResource::collection($countries),'',200);
    }
}
