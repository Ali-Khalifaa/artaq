<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StudentRequest;
use App\Http\Resources\Dashboard\StudentResource;
use App\Models\Nationality;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class StudentController extends Controller implements HasMiddleware
{


    public static function middleware(): array
    {
        return [
            new Middleware('can:student read', only: ['index']),
            new Middleware('can:student create', only: ['store']),
            new Middleware('can:student edit', only: ['update', 'show']),
            new Middleware('can:student delete', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        $students = Student::with('country','nationality','level')->searchAndFilter()->latest()->paginate(10);

        return responseJson(StudentResource::collection($students->items()),'',200,getPaginates($students));
    }



    public function store(StudentRequest $request)
    {
        $data = $request->validated();
        $data['image'] = store_single_image($request->image);
        Student::create($data);
        return responseJson([],'Created Successfully',200);
    }


    public function show($id)
    {
        $student = Student::find($id);
        return responseJson($student,'Data exited successfully',200);
    }

    public function update(StudentRequest $request, $id)
    {
        $data = $request->validated();
        $student = Student::find($id);
        if (!$student) {
            return responseJson([],'Data not found',404);
        }

         if($request->hasFile('image')){
            unlink_image_by_path($student->getAttributes()['image']);
            $data['image'] = store_single_image($request->image);
        }
        $student->update($data);
        return responseJson($student,'Updated Successfully',200);
    }

    public function destroy($id)
    {
        $student = Student::find($id);
        if (!$student) {
            return responseJson([],'Data not found',404);
        }
        unlink_image_by_path($student->getAttributes()['image']);
        $student->delete();
        return responseJson([],'Deleted Successfully',200);
    }
}
