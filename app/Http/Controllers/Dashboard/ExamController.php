<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AddTimeToExamRequest;
use App\Http\Requests\Dashboard\AddDegreeToExamRequest;
use App\Http\Resources\Dashboard\StudentExamResource;
use App\Models\StudentExam;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ExamController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('can:exam read', only: ['index']),
            new Middleware('can:add time to exam', only: ['store']),
            new Middleware('can:add degree to exam', only: ['update']),
        ];
    }

    public function index(Request $request)
    {
        $level = StudentExam::searchAndFilter()->latest()->paginate(10);

        return responseJson(StudentExamResource::collection($level->items()),'',200,getPaginates($level));
    }

    public function addTimeToExam(AddTimeToExamRequest $request, $id)
    {
        $data = $request->validated();
        StudentExam::find($id)->update($data);
        return responseJson([],'Created Successfully',200);
    }

    public function addDegreeToExam(AddDegreeToExamRequest $request, $id)
    {
        $data = $request->validated();
        StudentExam::find($id)->update($data);
        return responseJson([],'Created Successfully',200);
    }

}
