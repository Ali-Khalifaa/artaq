<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CircleTypeRequest;
use App\Http\Resources\Dashboard\CircleTypeResource;
use App\Models\CircleType;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CircleTypeController extends Controller implements HasMiddleware
{


    public static function middleware(): array
    {
        return [
            new Middleware('can:circle type read', only: ['index']),
            new Middleware('can:circle type create', only: ['store']),
            new Middleware('can:circle type edit', only: ['update', 'show']),
            new Middleware('can:circle type delete', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        $nationality = CircleType::searchAndFilter()->latest()->paginate(10);

        return responseJson(CircleTypeResource::collection($nationality->items()),'',200,getPaginates($nationality));
    }



    public function store(CircleTypeRequest $request)
    {
        $data = $request->validated();
        CircleType::create($data);
        return responseJson([],'Created Successfully',200);
    }


    public function show($id)
    {
        $nationality = CircleType::find($id);
        return responseJson($nationality,'Data exited successfully',200);
    }

    public function update(CircleTypeRequest $request, $id)
    {
        $data = $request->validated();
        $nationality = CircleType::find($id);
        if (!$nationality) {
            return responseJson([],'Data not found',404);
        }

        $nationality->update($data);
        return responseJson($nationality,'Updated Successfully',200);
    }

    public function destroy($id)
    {
        $nationality = CircleType::find($id);
        if (!$nationality) {
            return responseJson([],'Data not found',404);
        }
        $nationality->delete();
        return responseJson([],'Deleted Successfully',200);
    }

    public function dropdown()
    {
        $level = CircleType::all();

        return responseJson(CircleTypeResource::collection($level),'',200);
    }
}
