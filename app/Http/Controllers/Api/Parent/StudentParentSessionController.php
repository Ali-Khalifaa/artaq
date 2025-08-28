<?php

namespace App\Http\Controllers\Api\Parent;

use App\Enums\ExamStatusEnum;
use App\Enums\FreeSessionStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Student\FreeSessionResource;
use App\Http\Resources\Api\Student\IntensiveSessionResource;
use App\Http\Resources\Api\Student\StudentExamResource;
use App\Http\Resources\Api\Student\StudentLevelTasksResource;
use App\Http\Resources\Api\Student\TeacherResource;
use App\Http\Resources\Api\Teacher\CircleSessionStudentResource;
use App\Models\CircleDuration;
use App\Models\CircleSessionStudent;
use App\Models\FreeSession;
use App\Models\IntensiveSession;
use App\Models\StudentCircle;
use App\Models\StudentExam;
use App\Models\StudentLevelTask;
use App\Services\TwilioService;
use Carbon\Carbon;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class StudentParentSessionController extends Controller implements HasMiddleware
{
    public function __construct(private TwilioService $twilioService) {}

    public static function middleware(): array
    {
        return [
            new Middleware('auth:parent_api'),
        ];
    }

    public function previousFreeSessions($studentId)
    {
        $parent = auth("parent_api")->user();
        $student = $parent->students()->whereId($studentId)->first();
        if (!$student)
            return responseJson("", "هذا الطالب غير مسجل برقم هاتفك كولي امر", 400);
        $this->searchForFreeSessionsRequest();
        $sessions = FreeSession::searchAndFilter()->whereIn('status', [FreeSessionStatusEnum::COMPLETED, FreeSessionStatusEnum::CANCELED, FreeSessionStatusEnum::ACTIVE])->whereStudentId($studentId)->latest()->paginate(10);
        return responseJson(FreeSessionResource::collection($sessions->items()), '', 200, getPaginates($sessions));
    }

    public function previousIntensiveSessions($studentId)
    {
        $parent = auth("parent_api")->user();
        $student = $parent->students()->whereId($studentId)->first();
        if (!$student)
            return responseJson("", "هذا الطالب غير مسجل برقم هاتفك كولي امر", 400);
        $this->searchForIntensiveSessionsRequest();
        $sessions = IntensiveSession::searchAndFilter()->whereStatus(1)->whereRelation("intensiveStudy.intensiveRequest", "student_id", $studentId)->latest()->paginate(10);
        return responseJson(IntensiveSessionResource::collection($sessions->items()), '', 200, getPaginates($sessions));
    }

    public function nextIntensiveSession($studentId)
    {
        $parent = auth("parent_api")->user();
        $student = $parent->students()->whereId($studentId)->first();
        if (!$student)
            return responseJson("", "هذا الطالب غير مسجل برقم هاتفك كولي امر", 400);
        $nextSession = IntensiveSession::whereStatus(0)->whereRelation("intensiveStudy.intensiveRequest", "student_id", $studentId)->latest()->first();
        return responseJson($nextSession ? new IntensiveSessionResource($nextSession) : "");
    }


    public function nextCircleSession($studentId)
    {
        $parent = auth("parent_api")->user();
        $student = $parent->students()->whereId($studentId)->first();
        if (!$student)
            return responseJson("", "هذا الطالب غير مسجل برقم هاتفك كولي امر", 400);

        $studentCircle = StudentCircle::whereStatus(0)->whereStudentId($student->id)->first();
        if (!$studentCircle)
            return responseJson("", "لا يوجد حاليا جلسات قادمة", 200);
        $nextTask = StudentLevelTask::whereStudentId($student->id)->whereStatus(0)->whereStudentCircleId($studentCircle->id)->first();
        $nextDay = $this->getNextDay($studentCircle);

        $teacher = $studentCircle?->circle?->teachers?->first();
        return responseJson([
            "teacher" => new TeacherResource($teacher),
            "date_time" => $nextDay->next_datetime . "",
            "date_time" => $nextDay->next_datetime . "",
            "start_time" => $nextDay->start_time . "",
            "end_time" => $nextDay->end_time . "",
            "day" => __('messages.' . $nextDay->day),
            "manhag" => $nextTask?->fromSurah?->name . " ( " . $nextTask?->fromAyah?->text . " )  الى " . $nextTask?->toSurah?->name . " ( " . $nextTask?->toAyah?->text . " ) ",
            "review" => $nextTask?->reviewFromSurah?->name . " ( " . $nextTask?->reviewFromAyah?->text . " )  الى " . $nextTask?->reviewToSurah?->name . " ( " . $nextTask?->reviewToAyah?->text . " ) ",
        ]);
    }

    private function getNextDay($studentCircle)
    {
        return CircleDuration::whereCircleId($studentCircle->circle_id)->get()
            ->map(function ($item) {
                // determine numeric day index (0 = Sunday, 6 = Saturday)
                $dayNumber = null;

                // if day is already numeric
                if (is_numeric($item->day)) {
                    $dayNumber = intval($item->day);
                } else {
                    // try parsing common English weekday names
                    try {
                        $dayNumber = Carbon::parse($item->day)->dayOfWeek;
                    } catch (\Exception $e) {
                        $dayNumber = null;
                    }

                    // fallback: common Arabic weekday names mapping
                    if ($dayNumber === null) {
                        $arabicDays = [
                            'الأحد' => 0,
                            'الاثنين' => 1,
                            'الثلاثاء' => 2,
                            'الأربعاء' => 3,
                            'الخميس' => 4,
                            'الجمعة' => 5,
                            'السبت' => 6,
                        ];
                        $normalized = trim($item->day);
                        $dayNumber = $arabicDays[$normalized] ?? null;
                    }
                }

                // final fallback to today's weekday if nothing matched
                if ($dayNumber === null) {
                    $dayNumber = Carbon::now()->dayOfWeek;
                }

                // compute next date for that weekday and set start time
                $now = Carbon::now();
                $todayWeekday = $now->dayOfWeek;
                $daysToAdd = ($dayNumber - $todayWeekday + 7) % 7;
                $nextDate = $now->copy()->startOfDay()->addDays($daysToAdd)->setTimeFromTimeString($item->start_time);

                // compute end datetime for that occurrence
                $endDate = $nextDate->copy()->setTimeFromTimeString($item->end_time);

                // if the end datetime has already passed, move to next week's occurrence
                if ($endDate->lessThanOrEqualTo($now)) {
                    $nextDate->addWeek();
                }

                $item->next_datetime = $nextDate;
                return $item;
            })
            ->sortBy('next_datetime')
            ->first();
    }


    public function previousCircleSessions($studentId)
    {
        $parent = auth("parent_api")->user();
        $student = $parent->students()->whereId($studentId)->first();
        if (!$student)
            return responseJson("", "هذا الطالب غير مسجل برقم هاتفك كولي امر", 400);
        $this->searchForCircleSessionsRequest();
        $tasks = StudentLevelTask::searchAndFilter()->whereStudentId($student->id)->whereStatus(1)->latest()->paginate(15);
        return responseJson(StudentLevelTasksResource::collection($tasks->items()), '', 200, getPaginates($tasks));
    }

    public function getNextExam($studentId)
    {
        $parent = auth("parent_api")->user();
        $student = $parent->students()->whereId($studentId)->first();
        if (!$student)
            return responseJson("", "هذا الطالب غير مسجل برقم هاتفك كولي امر", 400);
        $exam = StudentExam::whereStatus(ExamStatusEnum::PENDING)->whereStudentId($student->id)->first();
        return responseJson($exam ? new StudentExamResource($exam) : "");
    }


    public function getPrevExams($studentId)
    {
        $parent = auth("parent_api")->user();
        $student = $parent->students()->whereId($studentId)->first();
        if (!$student)
            return responseJson("", "هذا الطالب غير مسجل برقم هاتفك كولي امر", 400);
        $exams = StudentExam::where("status", "!=", ExamStatusEnum::PENDING)->whereStudentId($student->id)->get();
        return responseJson(StudentExamResource::collection($exams));
    }

    public function circleSessionsAttends($studentId)
    {
        $parent = auth("parent_api")->user();
        $student = $parent->students()->whereId($studentId)->first();
        if (!$student)
            return responseJson("", "هذا الطالب غير مسجل برقم هاتفك كولي امر", 400);


        $sessions = CircleSessionStudent::whereNotNull("attends")->whereStudentId($student->id)->paginate(25);
        return responseJson(CircleSessionStudentResource::collection($sessions->items()),'',200,getPaginates($sessions));
    }


    protected function searchForIntensiveSessionsRequest()
    {
        if ($searchValue = request()->search)
            request()->merge([
                'search' => json_encode([
                    'searchKey' => $searchValue,
                    'searchInTranslations' => false,
                    'columns' => ['id'],
                    'searchInRelations' => [
                        [
                            'relation' => 'intensiveStudy.intensiveRequest.teacher',
                            'columns' => ['name', 'phone'],
                            'searchInRelationTranslations' => false
                        ],
                        [
                            'relation' => 'fromSurah',
                            'columns' => ['surahs.name'],
                            'searchInRelationTranslations' => false
                        ],
                        [
                            'relation' => 'toSurah',
                            'columns' => ['surahs.name'],
                            'searchInRelationTranslations' => false
                        ],
                        [
                            'relation' => 'fromAyah',
                            'columns' => ['ayahs.text'],
                            'searchInRelationTranslations' => false
                        ],
                        [
                            'relation' => 'toAyah',
                            'columns' => ['ayahs.text'],
                            'searchInRelationTranslations' => false
                        ],

                    ]
                ])
            ]);
    }

    protected function searchForFreeSessionsRequest()
    {
        if ($searchValue = request()->search)
            request()->merge([
                'search' => json_encode([
                    'searchKey' => $searchValue,
                    'searchInTranslations' => false,
                    'columns' => ['id'],
                    'searchInRelations' => [
                        [
                            'relation' => 'teacher',
                            'columns' => ['name', 'phone'],
                            'searchInRelationTranslations' => false
                        ],
                        [
                            'relation' => 'fromSurah',
                            'columns' => ['surahs.name'],
                            'searchInRelationTranslations' => false
                        ],
                        [
                            'relation' => 'toSurah',
                            'columns' => ['surahs.name'],
                            'searchInRelationTranslations' => false
                        ],
                        [
                            'relation' => 'fromAyah',
                            'columns' => ['ayahs.text'],
                            'searchInRelationTranslations' => false
                        ],
                        [
                            'relation' => 'toAyah',
                            'columns' => ['ayahs.text'],
                            'searchInRelationTranslations' => false
                        ],

                    ]
                ])
            ]);
    }

    protected function searchForCircleSessionsRequest()
    {
        if ($searchValue = request()->search)
            request()->merge([
                'search' => json_encode([
                    'searchKey' => $searchValue,
                    'searchInTranslations' => false,
                    'columns' => ['id'],
                    'searchInRelations' => [
                        [
                            'relation' => 'circle.teacher',
                            'columns' => ['name', 'phone'],
                            'searchInRelationTranslations' => false
                        ],
                        [
                            'relation' => 'circle',
                            'columns' => ['name'],
                            'searchInRelationTranslations' => false
                        ],
                        [
                            'relation' => 'level',
                            'columns' => ['name'],
                            'searchInRelationTranslations' => false
                        ],
                        [
                            'relation' => 'fromSurah',
                            'columns' => ['surahs.name'],
                            'searchInRelationTranslations' => false
                        ],
                        [
                            'relation' => 'toSurah',
                            'columns' => ['surahs.name'],
                            'searchInRelationTranslations' => false
                        ],
                        [
                            'relation' => 'fromAyah',
                            'columns' => ['ayahs.text'],
                            'searchInRelationTranslations' => false
                        ],
                        [
                            'relation' => 'toAyah',
                            'columns' => ['ayahs.text'],
                            'searchInRelationTranslations' => false
                        ],
                        [
                            'relation' => 'reviewFromSurah',
                            'columns' => ['surahs.name'],
                            'searchInRelationTranslations' => false
                        ],
                        [
                            'relation' => 'reviewToSurah',
                            'columns' => ['surahs.name'],
                            'searchInRelationTranslations' => false
                        ],
                        [
                            'relation' => 'reviewFromAyah',
                            'columns' => ['ayahs.text'],
                            'searchInRelationTranslations' => false
                        ],
                        [
                            'relation' => 'reviewToAyah',
                            'columns' => ['ayahs.text'],
                            'searchInRelationTranslations' => false
                        ],

                    ]
                ])
            ]);
    }
}
