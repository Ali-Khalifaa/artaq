<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\ExamStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CircleRequest;
use App\Http\Resources\Dashboard\CircleResource;
use App\Http\Resources\Dashboard\StudentResource;
use App\Models\Circle;
use App\Models\Level;
use App\Models\Student;
use App\Models\StudentCircle;
use App\Models\StudentLevelTask;
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
            new Middleware('can:student without circle read', only: ['studentWithoutCircles']),
            new Middleware('can:add circle to student', only: ['assignStudentToCircle']),
        ];
    }

    public function index(Request $request)
    {
        $nationality = Circle::with('circleType')->searchAndFilter()->latest()->paginate(10);

        return responseJson(CircleResource::collection($nationality->items()), '', 200, getPaginates($nationality));
    }

    public function store(CircleRequest $request)
    {
        $data = $request->validated();
        $circle = Circle::create($data);

        foreach ($data['duration'] as $duration) {
            $circle->circleDurations()->create($duration);
        }

        return responseJson([], 'Created Successfully', 200);
    }


    public function show($id)
    {
        $nationality = Circle::find($id);
        return responseJson($nationality, 'Data exited successfully', 200);
    }

    public function update(CircleRequest $request, $id)
    {
        $data = $request->validated();
        $circle = Circle::find($id);
        if (!$circle) {
            return responseJson([], 'Data not found', 404);
        }

        $circle->update($data);
        $circle->circleDurations()->delete();
        foreach ($data['duration'] as $duration) {
            $circle->circleDurations()->create($duration);
        }
        return responseJson($circle, 'Updated Successfully', 200);
    }

    public function destroy($id)
    {
        $circle = Circle::find($id);
        if (!$circle) {
            return responseJson([], 'Data not found', 404);
        }
        $circle->delete();
        return responseJson([], 'Deleted Successfully', 200);
    }

    public function dropdown()
    {
        $level = Circle::all();

        return responseJson(CircleResource::collection($level), '', 200);
    }

    public function circlesWithTeacher(Request $request)
    {
        $circles = Circle::whereHas('teachers')->where('gender', $request->gender)->where('status', 1)->get();

        return responseJson(CircleResource::collection($circles), '', 200);
    }

    public function circlesWithoutTeacher($id)
    {
        $teacher = Teacher::find($id);
        $circles = Circle::doesntHave('teachers')->where('gender', $teacher->gender)->get();

        $teacherCircles = $teacher ? $teacher->circles()->get() : collect();

        // Merge teacher's circles into the circles collection
        $circles = $circles->concat($teacherCircles)->unique('id')->values();


        return responseJson($circles, '', 200);
    }

    public function studentWithoutCircles()
    {
        $students = Student::whereTrackId(2)
            ->whereDoesntHave('circles', function ($q) {
                $q->where('student_circles.status', 0)
                ->orWhere('circles.status', 0);
            })
            ->whereDoesntHave('exams', function ($q) {
                $q->where('student_exams.status', ExamStatusEnum::PENDING);
            })
            ->with(['country', 'nationality', 'level'])
            ->searchAndFilter()
            ->latest()
            ->paginate(10);

        return responseJson(StudentResource::collection($students->items()), '', 200, getPaginates($students));
    }

    public function assignStudentToCircle($studentId, $circleId)
    {
        $student = Student::whereTrackId(2)->whereDoesntHave('circles', function ($q) {
                $q->where('student_circles.status', 0)
                ->orWhere('circles.status', 0);
            })->find($studentId);
        $circle = Circle::where('gender', $student?->gender)->find($circleId);
        if (!$student || !$circle)
            return responseJson('', __('messages.not_found'), 400);

        $studentCircle = StudentCircle::create([
            'student_id' => $student->id,
            'circle_id' => $circle->id,
        ]);

        $levels = Level::where('id', '>=', $student->level_id)->wherePreservationMethodId($student->preservation_method_id)->get();

        foreach ($levels as $level) {
            foreach ($level->levelTasks as $task) {
                StudentLevelTask::create([
                    "student_circle_id" => $studentCircle->id,
                    "circle_id" => $circle->id,
                    "student_id" => $student->id,
                    "level_id" => $task->level_id,
                    "from_surah_id" => $task->from_surah_id,
                    "to_surah_id" => $task->to_surah_id,
                    "from_ayah_id" => $task->from_ayah_id,
                    "to_ayah_id" => $task->to_ayah_id,
                    "review_from_surah_id" => $task->review_from_surah_id,
                    "review_to_surah_id" => $task->review_to_surah_id,
                    "review_from_ayah_id" => $task->review_from_ayah_id,
                    "review_to_ayah_id" => $task->review_to_ayah_id,
                ]);
            }
        }

        return responseJson("","",200);
    }


}
