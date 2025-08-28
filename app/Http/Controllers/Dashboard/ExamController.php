<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\ExamStatusEnum;
use App\Enums\RequestActionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AddTimeToExamRequest;
use App\Http\Requests\Dashboard\AddDegreeToExamRequest;
use App\Http\Resources\Dashboard\StudentExamResource;
use App\Models\IntensiveSession;
use App\Models\IntensiveStudy;
use App\Models\StudentCircle;
use App\Models\StudentExam;
use App\Models\StudentLevelTask;
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

        return responseJson(StudentExamResource::collection($level->items()), '', 200, getPaginates($level));
    }

    public function addTimeToExam(AddTimeToExamRequest $request, $id)
    {
        $data = $request->validated();
        $exam = StudentExam::find($id)->update($data);
        $student = $exam->student;
        $title = "تم تحديد موعد امتحانك";
        $message = "قام المشرف بتحديد موعد امتحانك {$exam->name} بتاريخ {$request->date_time} على هذا الرابط {$request->link}";
        sendNotification($student, [], 'add-time-to-exam', asset('assets/images/brand-logos/toggle-white.png'), $title, $message);
        if ($parent = $student->parent) {
            $childName = $student->name ?? $student->phone;
            $titleParent = "تم تحديد موعد امتحان ل {$childName}";
            $message = "قام المشرف بتحديد موعد امتحان ل {$childName} {$exam->name} بتاريخ {$request->date_time} على هذا الرابط {$request->link}";
            sendNotification($parent, [], 'exam-added-for-child', asset('assets/images/brand-logos/toggle-white.png'), $titleParent, $message);
        }
        return responseJson([], 'Created Successfully', 200);
    }

    public function addDegreeToExam(AddDegreeToExamRequest $request, $id)
    {
        $data = $request->validated();
        $exam = StudentExam::find($id);

        if ($exam) {
            $degree = $exam->degree ?? ($data['degree'] ?? null);
            $student = $exam->student;
            $model = $exam->model;

            if ($degree < 50) {
                $title = "لقد رسبت في الامتحان";
                $message = "للأسف لم تحصل على الدرجة الكافية في الامتحان {$exam->name}. درجتك: {$degree} وسيتم اعادة المنهج مرة اخرى";
                sendNotification($student, [], 'exam-failed', asset('assets/images/brand-logos/toggle-white.png'), $title, $message);
                if ($parent = $student->parent) {
                    $childName = $student->name ?? $student->phone;
                    $titleParent = "لقد رسب {$childName} في الاختبار وسيتم اعادة المستوى";
                    $message = "للأسف لم يحصل على الدرجة الكافية في الامتحان {$exam->name}. درجته: {$degree} وسيتم اعادة المنهج مرة اخرى";
                    sendNotification($parent, [], 'exam-failed', asset('assets/images/brand-logos/toggle-white.png'), $titleParent, $message);
                }
                $data['status'] = ExamStatusEnum::FAILED;
                $this->failedExamTrack2($exam, $model, $student);
                $this->failedExamTrack3($exam, $model, $student);
            } else {


                $data['status'] = ExamStatusEnum::SUCCESSED;

                $this->successedExamTrack2($exam, $model, $student, $degree);
                $this->successedExamTrack3($exam, $model, $student, $degree);
            }
            $exam->update($data);
        }
        return responseJson([], 'Created Successfully', 200);
    }

    private function failedExamTrack3($exam, $model, $student)
    {
        if ($exam->track_id == 3) {
            $model->update(["is_completed" => 0]);
            $model->intensiveSessions()->delete();
        }
    }
    private function successedExamTrack3($exam, $model, $student, $degree)
    {
        if ($exam->track_id == 3) {
            $model->update(["had_exam" => 1]);
            $nextStudy = IntensiveStudy::where("intensive_request_id", $model->intensive_request_id)->whereStatus(0)->first();

            if ($nextStudy) {
                $nextStudy->update(['status' => 1]);
                $dateTime = now()->addDay()->format("Y-m-d") . " " . $nextStudy->intensiveRequest?->time;
                IntensiveSession::create([
                    'intensive_study_id' => $nextStudy->id,
                    'date' => $dateTime
                ]);
                $title = "تم نجاحك في الامتحان";
                $message = "مبروك! نجحت في الامتحان {$exam->name} بدرجة {$degree} وتمت ترقيتك للمستوى التالي, لا تنسى موعد الجلسة القادمة لبدء التسميع داخل الخمس اجزاء التالية {$dateTime}.";
                sendNotification($student, [], 'move-to-next-study', asset('assets/images/brand-logos/toggle-white.png'), $title, $message);

                if ($parent = $student->parent) {
                    $childName = $student->name ?? $student->phone;
                    $titleParent = "لقد نجح {$childName} في الاختبار ";
                    $message = "مبروك! نجح في الامتحان {$exam->name} بدرجة {$degree} وتمت ترقيته للمستوى التالي.";
                    sendNotification($parent, [], 'exam-successed', asset('assets/images/brand-logos/toggle-white.png'), $titleParent, $message);
                }
            } else {
                $title = "لقد اتممت المسار المكثف بنجاح";
                $message = "لقد قمت بأتمام المسار المكثف بنجاح مع المعلم {$model->intensiveRequest?->teacher?->name}, انت الان اصبحت في المسار الحر";
                sendNotification($student, [], 'intensive-path-completed', asset('assets/images/brand-logos/toggle-white.png'), $title, $message);

                if ($parent = $student->parent) {
                    $childName = $student->name ?? $student->phone;
                    $titleParent = "لقد اتم {$childName} المسار المكثف بنجاح";
                    $message = "لقد قام بأتمام المسار المكثف بنجاح مع المعلم {$model->intensiveRequest?->teacher?->name}, والان اصبح في المسار الحر";
                    sendNotification($parent, [], 'intensive-path-completed', asset('assets/images/brand-logos/toggle-white.png'), $titleParent, $message);
                }
                $model->intensiveRequest()->update(['status' => RequestActionEnum::COMPLETED]);
                $student->update(['level_id' => null, 'preservation_method_id' => null, "track_id" => 1]);
            }
        }
    }
    private function failedExamTrack2($exam, $model, $student)
    {
        if ($exam->track_id == 2) {
            StudentLevelTask::whereStudentId($student->id)->whereLevelId($model->id)->whereStatus(1)->update(['status' => 0]);
        }
    }
    private function successedExamTrack2($exam, $model, $student, $degree)
    {
        if ($exam->track_id == 2) {
            $nextLevel = StudentLevelTask::whereStudentId($student->id)->whereLevelId($model->id)->whereStatus(0)->first();

            if ($nextLevel) {
                $student->update(['level_id' => $nextLevel->level_id]);
                $title = "تم نجاحك في الامتحان";
                $message = "مبروك! نجحت في الامتحان {$exam->name} بدرجة {$degree} وتم نقلك الى المستوى التالي {$nextLevel->level->name}.";
                sendNotification($student, [], 'move-to-next-level', asset('assets/images/brand-logos/toggle-white.png'), $title, $message);

                if ($parent = $student->parent) {
                    $childName = $student->name ?? $student->phone;
                    $titleParent = "لقد نجح {$childName} في الاختبار ";
                    $message = "مبروك! لقد نجح في الامتحان {$exam->name} بدرجة {$degree} وتم نقله الى المستوى التالي {$nextLevel->level->name}.";
                    sendNotification($parent, [], 'exam-successed', asset('assets/images/brand-logos/toggle-white.png'), $titleParent, $message);
                }
            } else {
                $studentCircle = StudentCircle::whereStudentId($student->id)->whereStatus(0)->first();
                $studentCircle->update(['status' => 1]);
                $teacherName = $studentCircle->circle?->teachers?->first()?->name ?? "";
                $title = "لقد اتممت مسار الحلقات بنجاح";
                $message = "لقد قمت بأتمام مسار الحلقات بنجاح مع المعلم {$teacherName}, انت الان اصبحت في المسار الحر";
                sendNotification($student, [], 'circle-path-completed', asset('assets/images/brand-logos/toggle-white.png'), $title, $message);

                if ($parent = $student->parent) {
                    $childName = $student->name ?? $student->phone;
                    $titleParent = "لقد اتم {$childName} مسار الحلقات بنجاح ";
                    $message = "لقد قام بأتمام مسار الحلقات بنجاح مع المعلم {$teacherName}, والان اصبح في المسار الحر";
                    sendNotification($parent, [], 'exam-successed', asset('assets/images/brand-logos/toggle-white.png'), $titleParent, $message);
                }
                $student->update(['level_id' => null, 'preservation_method_id' => null, "track_id" => 1]);
            }
        }
    }
}
