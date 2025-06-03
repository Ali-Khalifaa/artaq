<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CircleRequest;
use App\Http\Resources\Dashboard\CircleResource;
use App\Models\Circle;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CircleController extends Controller implements HasMiddleware
{


    public static function middleware(): array
    {
        return [
            new Middleware('can:circle read', only: ['index']),
            new Middleware('can:circle create', only: ['store']),
            new Middleware('can:circle edit', only: ['update', 'show']),
            new Middleware('can:circle delete', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        $nationality = Circle::with('circleType')->searchAndFilter()->latest()->paginate(10);

        return responseJson(CircleResource::collection($nationality->items()),'',200,getPaginates($nationality));
    }

    public function store(CircleRequest $request)
    {
        $data = $request->validated();
        $circle = Circle::create($data);

        foreach ($data['duration'] as $duration) {
            $circle->circleDurations()->create($duration);
        }

        return responseJson([],'Created Successfully',200);
    }


    public function show($id)
    {
        $nationality = Circle::find($id);
        return responseJson($nationality,'Data exited successfully',200);
    }

    public function update(CircleRequest $request, $id)
    {
        $data = $request->validated();
        $circle = Circle::find($id);
        if (!$circle) {
            return responseJson([],'Data not found',404);
        }

        $circle->update($data);
        $circle->circleDurations()->delete();
        foreach ($data['duration'] as $duration) {
            $circle->circleDurations()->create($duration);
        }
        return responseJson($circle,'Updated Successfully',200);
    }

    public function destroy($id)
    {
        $circle = Circle::find($id);
        if (!$circle) {
            return responseJson([],'Data not found',404);
        }
        $circle->delete();
        return responseJson([],'Deleted Successfully',200);
    }

    public function dropdown()
    {
        $level = Circle::all();

        return responseJson(CircleResource::collection($level),'',200);
    }

    public function circlesWithoutTeacher($id)
    {
        $teacher = Teacher::find($id);
        $circles = Circle::doesntHave('teachers')->where('gender',$teacher->gender)->get();

        $teacherCircles = $teacher ? $teacher->circles()->get() : collect();

        // Merge teacher's circles into the circles collection
        $circles = $circles->concat($teacherCircles)->unique('id')->values();


        return responseJson($circles,'',200);
    }
}
