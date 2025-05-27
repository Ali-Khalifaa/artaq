<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\NationalityRequest;
use App\Http\Resources\Dashboard\NationalityResource;
use App\Models\Nationality;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class NationalityController extends Controller implements HasMiddleware
{


    public static function middleware(): array
    {
        return [
            new Middleware('can:nationality read', only: ['index']),
            new Middleware('can:nationality create', only: ['store']),
            new Middleware('can:nationality edit', only: ['update', 'show']),
            new Middleware('can:nationality delete', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        $nationality = Nationality::searchAndFilter()->latest()->paginate(10);

        return responseJson(NationalityResource::collection($nationality->items()),'',200,getPaginates($nationality));
    }



    public function store(NationalityRequest $request)
    {
        $data = $request->validated();
        Nationality::create($data);
        return responseJson([],'Created Successfully',200);
    }


    public function show($id)
    {
        $nationality = Nationality::find($id);
        return responseJson($nationality,'Data exited successfully',200);
    }

    public function update(NationalityRequest $request, $id)
    {
        $data = $request->validated();
        $nationality = Nationality::find($id);
        if (!$nationality) {
            return responseJson([],'Data not found',404);
        }

        $nationality->update($data);
        return responseJson($nationality,'Updated Successfully',200);
    }

    public function destroy($id)
    {
        $nationality = Nationality::find($id);
        if (!$nationality) {
            return responseJson([],'Data not found',404);
        }
        $nationality->delete();
        return responseJson([],'Deleted Successfully',200);
    }

    public function dropdown()
    {
        $level = Nationality::all();

        return responseJson(NationalityResource::collection($level),'',200);
    }
}
