<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CirclePlaceRequest;
use App\Http\Resources\Dashboard\CircleTypeResource;
use App\Models\CirclePlace;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CirclePlaceController extends Controller implements HasMiddleware
{


    public static function middleware(): array
    {
        return [
            new Middleware('can:circle place read', only: ['index']),
            new Middleware('can:circle place create', only: ['store']),
            new Middleware('can:circle place edit', only: ['update', 'show']),
            new Middleware('can:circle place delete', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        $nationality = CirclePlace::searchAndFilter()->latest()->paginate(10);

        return responseJson(CircleTypeResource::collection($nationality->items()),'',200,getPaginates($nationality));
    }



    public function store(CirclePlaceRequest $request)
    {
        $data = $request->validated();
        CirclePlace::create($data);
        return responseJson([],'Created Successfully',200);
    }


    public function show($id)
    {
        $nationality = CirclePlace::find($id);
        return responseJson($nationality,'Data exited successfully',200);
    }

    public function update(CirclePlaceRequest $request, $id)
    {
        $data = $request->validated();
        $nationality = CirclePlace::find($id);
        if (!$nationality) {
            return responseJson([],'Data not found',404);
        }

        $nationality->update($data);
        return responseJson($nationality,'Updated Successfully',200);
    }

    public function destroy($id)
    {
        $nationality = CirclePlace::find($id);
        if (!$nationality) {
            return responseJson([],'Data not found',404);
        }
        $nationality->delete();
        return responseJson([],'Deleted Successfully',200);
    }

    public function dropdown()
    {
        $level = CirclePlace::all();

        return responseJson(CircleTypeResource::collection($level),'',200);
    }
}
