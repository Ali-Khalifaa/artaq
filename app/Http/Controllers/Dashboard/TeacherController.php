<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ChangeAdminRequest;
use App\Http\Requests\Dashboard\ModifyCirclesRequest;
use App\Http\Requests\Dashboard\TeacherRequest;
use App\Http\Resources\Dashboard\TeacherResource;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class TeacherController extends Controller implements HasMiddleware
{


    public static function middleware(): array
    {
        return [
            new Middleware('can:teacher read', only: ['index']),
            new Middleware('can:teacher create', only: ['store']),
            new Middleware('can:teacher edit', only: ['update', 'show']),
            new Middleware('can:teacher delete', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        $teacher = Teacher::with('country','nationality','admin','circles')->searchAndFilter()->latest()->paginate(10);

        return responseJson(TeacherResource::collection($teacher->items()),'',200,getPaginates($teacher));
    }



    public function store(TeacherRequest $request)
    {
        $data = $request->validated();
        $data['image'] = store_single_image($request->image);
        Teacher::create($data);
        return responseJson([],'Created Successfully',200);
    }


    public function show($id)
    {
        $nationality = Teacher::find($id);
        return responseJson($nationality,'Data exited successfully',200);
    }

    public function update(TeacherRequest $request, $id)
    {
        $data = $request->validated();
        $nationality = Teacher::find($id);
        if (!$nationality) {
            return responseJson([],'Data not found',404);
        }

         if($request->hasFile('image')){
            unlink_image_by_path($nationality->getAttributes()['image']);
            $data['image'] = store_single_image($request->image);
        }
        $nationality->update($data);
        return responseJson($nationality,'Updated Successfully',200);
    }

    public function destroy($id)
    {
        $nationality = Teacher::find($id);
        if (!$nationality) {
            return responseJson([],'Data not found',404);
        }
        unlink_image_by_path($nationality->getAttributes()['image']);
        $nationality->delete();
        return responseJson([],'Deleted Successfully',200);
    }

    public function changeAdmin(ChangeAdminRequest $request, $id)
    {
        $data = $request->validated();
        $teacher = Teacher::find($id);
        $teacher->update($data);
        return responseJson($teacher,'Updated Successfully',200);
    }

    public function modifyCircles(ModifyCirclesRequest $request, $id)
    {
        $teacher = Teacher::find($id);
        if (!$teacher) {
            return responseJson([],'Data not found',404);
        }

         $data = $request->validated();

        $teacher->circles()->sync($data['circles']);

        return responseJson([], 'Circles updated successfully', 200);
    }
}
