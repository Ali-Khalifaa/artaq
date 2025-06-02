<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\LevelRequest;
use App\Http\Resources\Dashboard\LevelResource;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class LevelController extends Controller implements HasMiddleware
{


    public static function middleware(): array
    {
        return [
            new Middleware('can:level read', only: ['index']),
            new Middleware('can:level create', only: ['store']),
            new Middleware('can:level edit', only: ['update', 'show']),
            new Middleware('can:level delete', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        $level = Level::with('preservationMethod')->searchAndFilter()->latest()->paginate(10);

        return responseJson(LevelResource::collection($level->items()),'',200,getPaginates($level));
    }



    public function store(LevelRequest $request)
    {
        $data = $request->validated();
        Level::create($data);
        return responseJson([],'Created Successfully',200);
    }


    public function show($id)
    {
        $level = Level::find($id);
        return responseJson($level,'Data exited successfully',200);
    }

    public function update(LevelRequest $request, $id)
    {
        $data = $request->validated();
        $level = Level::find($id);
        if (!$level) {
            return responseJson([],'Data not found',404);
        }

        $level->update($data);
        return responseJson($level,'Updated Successfully',200);
    }

    public function destroy($id)
    {
        $level = Level::find($id);
        if (!$level) {
            return responseJson([],'Data not found',404);
        }
        $level->delete();
        return responseJson([],'Deleted Successfully',200);
    }

     public function dropdown(Request $request)
    {
        if ($request->preservation_method_id) {
            $level = Level::where('preservation_method_id', $request->preservation_method_id)->get();
        } else {
            $level = Level::all();
        }

        return responseJson(LevelResource::collection($level),'',200);
    }
}
