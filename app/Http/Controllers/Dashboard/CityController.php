<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CityRequest;
use App\Http\Resources\Dashboard\CityResource;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CityController extends Controller implements HasMiddleware
{


    public static function middleware(): array
    {
        return [
            new Middleware('can:city read', only: ['index']),
            new Middleware('can:city create', only: ['store']),
            new Middleware('can:city edit', only: ['update', 'show']),
            new Middleware('can:city delete', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        $banners = City::searchAndFilter()->latest()->paginate(10);

        return responseJson(CityResource::collection($banners->items()),'',200,getPaginates($banners));
    }



    public function store(CityRequest $request)
    {
        $data = $request->validated();
        City::create($data);
        return responseJson([],'Created Successfully',200);
    }


    public function show($id)
    {
        $category = City::with('translations')->find($id);
        return responseJson($category,'Data exited successfully',200);
    }

    public function update(CityRequest $request, City $city)
    {
        $data = $request->validated();

        $city->update($data);
        return responseJson($city,'Updated Successfully',200);
    }

    public function destroy(City $city)
    {
        $city->delete();
        return responseJson([],'Deleted Successfully',200);
    }
    
    public function getCitiesByCountryId($countryId)
    {
        $cities = City::where('country_id', $countryId)->get();
        return responseJson(CityResource::collection($cities), 'Cities retrieved successfully', 200);
    }
}
