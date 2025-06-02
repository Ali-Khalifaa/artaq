<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\TrackRequest;
use App\Http\Resources\Dashboard\TrackResource;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class TrackController extends Controller implements HasMiddleware
{


    public static function middleware(): array
    {
        return [
            new Middleware('can:track read', only: ['index']),
            new Middleware('can:track create', only: ['store']),
            new Middleware('can:track edit', only: ['update', 'show']),
            new Middleware('can:track delete', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        $tracks = Track::searchAndFilter()->latest()->paginate(10);

        return responseJson(TrackResource::collection($tracks->items()),'',200,getPaginates($tracks));
    }



    public function store(TrackRequest $request)
    {
        $data = $request->validated();
        Track::create($data);
        return responseJson([],'Created Successfully',200);
    }


    public function show($id)
    {
        $nationality = Track::find($id);
        return responseJson($nationality,'Data exited successfully',200);
    }

    public function update(TrackRequest $request, $id)
    {
        $data = $request->validated();
        $nationality = Track::find($id);
        if (!$nationality) {
            return responseJson([],'Data not found',404);
        }

        $nationality->update($data);
        return responseJson($nationality,'Updated Successfully',200);
    }

    public function destroy($id)
    {
        $nationality = Track::find($id);
        if (!$nationality) {
            return responseJson([],'Data not found',404);
        }
        $nationality->delete();
        return responseJson([],'Deleted Successfully',200);
    }

    public function dropdown()
    {
        $level = Track::all();

        return responseJson(TrackResource::collection($level),'',200);
    }
}
