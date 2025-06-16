<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\PreservationMethodRequest;
use App\Http\Resources\Dashboard\PreservationMethodResource;
use App\Models\PreservationMethod;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PreservationMethodController extends Controller implements HasMiddleware
{


    public static function middleware(): array
    {
        return [
            new Middleware('can:memorization type read', only: ['index']),
            new Middleware('can:memorization type create', only: ['store']),
            new Middleware('can:memorization type edit', only: ['update', 'show']),
            new Middleware('can:memorization type delete', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        $memorization = PreservationMethod::with('track')->searchAndFilter()->latest()->paginate(10);

        return responseJson(PreservationMethodResource::collection($memorization->items()),'',200,getPaginates($memorization));
    }



    public function store(PreservationMethodRequest $request)
    {
        $data = $request->validated();
        PreservationMethod::create($data);
        return responseJson([],'Created Successfully',200);
    }


    public function show($id)
    {
        $memorization = PreservationMethod::find($id);
        return responseJson($memorization,'Data exited successfully',200);
    }

    public function update(PreservationMethodRequest $request, $id)
    {
        $data = $request->validated();
        $memorization = PreservationMethod::find($id);
        if (!$memorization) {
            return responseJson([],'Data not found',404);
        }

        $memorization->update($data);
        return responseJson($memorization,'Updated Successfully',200);
    }

    public function destroy($id)
    {
        $memorization = PreservationMethod::find($id);
        if (!$memorization) {
            return responseJson([],'Data not found',404);
        }
        $memorization->delete();
        return responseJson([],'Deleted Successfully',200);
    }

    public function dropdown()
    {
        $level = PreservationMethod::all();

        return responseJson(PreservationMethodResource::collection($level),'',200);
    }
}
