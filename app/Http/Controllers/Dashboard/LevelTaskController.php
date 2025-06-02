<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\LevelTaskRequest;
use App\Http\Resources\Dashboard\LevelTaskResource;
use App\Models\LevelTask;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class LevelTaskController extends Controller implements HasMiddleware
{


    public static function middleware(): array
    {
        return [
            new Middleware('can:level task read', only: ['index']),
            new Middleware('can:level task create', only: ['store']),
            new Middleware('can:level task edit', only: ['update', 'show']),
            new Middleware('can:level task delete', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        $level = LevelTask::with('level','fromSurah','toSurah','fromAyah','toAyah')->searchAndFilter()->latest()->paginate(10);

        return responseJson(LevelTaskResource::collection($level->items()),'',200,getPaginates($level));
    }



    public function store(LevelTaskRequest $request)
    {
        $data = $request->validated();
        LevelTask::create($data);
        return responseJson([],'Created Successfully',200);
    }


    public function show($id)
    {
        $level = LevelTask::find($id);
        return responseJson($level,'Data exited successfully',200);
    }

    public function update(LevelTaskRequest $request, $id)
    {
        $data = $request->validated();
        $level = LevelTask::find($id);
        if (!$level) {
            return responseJson([],'Data not found',404);
        }

        $level->update($data);
        return responseJson($level,'Updated Successfully',200);
    }

    public function destroy($id)
    {
        $level = LevelTask::find($id);
        if (!$level) {
            return responseJson([],'Data not found',404);
        }
        $level->delete();
        return responseJson([],'Deleted Successfully',200);
    }

     public function dropdown()
    {
        $level = LevelTask::all();

        return responseJson(LevelTaskResource::collection($level),'',200);
    }
}
