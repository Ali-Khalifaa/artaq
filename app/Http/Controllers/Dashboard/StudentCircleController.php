<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StudentRequest;
use App\Http\Resources\Dashboard\StudentResource;
use App\Models\Circle;
use App\Models\LevelTask;
use App\Models\Nationality;
use App\Models\Student;
use App\Models\StudentCircle;
use App\Models\StudentLevelTask;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class StudentCircleController extends Controller implements HasMiddleware
{


    public static function middleware(): array
    {
        return [
            new Middleware('can:student circle read', only: ['index']),
            new Middleware('can:student circle create', only: ['store']),
            new Middleware('can:student circle edit', only: ['update', 'show']),
            new Middleware('can:student circle delete', only: ['destroy']),
        ];
    }


    public function update($studentId, $circleId)
    {
        // $data = $request->validated();
        $student = Student::find($studentId);
        $circle = Circle::find($circleId);
        if (!$student || !$circle) {
            return responseJson([], 'Data not found', 404);
        }

        if ($student->level_id && $student->track_id == 2) {
            return responseJson([], 'Data not found', 404);
        }

        StudentCircle::create([
            "student_id" => $studentId,
            "circle_id" => $circleId,
        ]);

        foreach (LevelTask::whereLevelId($student->level_id)->get() as $task) {
            StudentLevelTask::create([
                'student_id' => $studentId,
                'level_id' => $task->level_id,
                'from_surah_id' => $task->from_surah_id,
                'to_surah_id' => $task->to_surah_id,
                'from_ayah_id' => $task->from_ayah_id,
                'to_ayah_id' => $task->to_ayah_id,

                "review_from_surah_id" => $task->review_from_surah_id ?? null,
                "review_to_surah_id" => $task->review_to_surah_id ?? null,
                "review_from_ayah_id" => $task->review_from_ayah_id ?? null,
                "review_to_ayah_id" => $task->review_to_ayah_id ?? null,

            ]);
        }

        return responseJson($student, 'Updated Successfully', 200);
    }
}
