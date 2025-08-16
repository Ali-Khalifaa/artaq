<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Enums\RequestActionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SurahAndAyahRequest;
use App\Http\Resources\Api\SurahResource;
use App\Http\Resources\Api\Teacher\IntensiveRequestResource;
use App\Http\Resources\Api\Teacher\IntensiveSessionResource;
use App\Models\Ayah;
use App\Models\FreeSession;
use App\Models\IntensiveRequest;
use App\Models\IntensiveSession;
use App\Models\IntensiveStudy;
use App\Models\Rating;
use App\Models\Student;
use App\Models\StudentExam;
use App\Models\Surah;
use App\Models\Teacher;
use App\Notifications\MessageNotification;

class IntensiveSessionsController extends Controller
{


    public function getIntensiveRequests()
    {
        $freeSessions = IntensiveRequest::whereStatus(RequestActionEnum::WAITING)->whereTeacherId(auth('teacher_api')->id())->get();
        return responseJson(IntensiveRequestResource::collection($freeSessions));
    }

    public function getActiveIntensiveRequests()
    {
        $currentSessions = IntensiveRequest::whereStatus(RequestActionEnum::ACCEPT)->whereTeacherId(auth('teacher_api')->id())->get();
        return responseJson(IntensiveRequestResource::collection($currentSessions));
    }

    public function acceptSessionRequest($id)
    {
        request()->validate(['time' => "required|date_format:h:i A"]);
        $teacher = auth("teacher_api")->user();

        $intensiveRequest = IntensiveRequest::whereStatus(RequestActionEnum::WAITING)->whereTeacherId(auth('teacher_api')->id())->find($id);
        if (!$intensiveRequest)
            return responseJson("", __('messages.not_found'), 400);
        if (!IntensiveRequest::where('time', request()->time)->whereStatus(RequestActionEnum::ACCEPT)->whereTeacherId(auth('teacher_api')->id())->exists())
            return responseJson("", "لديك موعد في هذا الوقت بالفعل يجب اختيار موعد اخر", 400);
        if (IntensiveRequest::whereStatus(RequestActionEnum::ACCEPT)->whereTeacherId(auth('teacher_api')->id())->count() >= 7) {
            IntensiveRequest::whereStatus(RequestActionEnum::WAITING)->whereTeacherId(auth('teacher_api')->id())->update(['status' => RequestActionEnum::REJECT]);
            return responseJson("", "لقد وصلت للحد الاقصى من الطلاب في المسار المكثف وهو 7 طلاب فقط يمكنك متابعتهم داخل هذا المسار", 400);
        }


        $intensiveRequest->update(['status' => RequestActionEnum::ACCEPT, 'time' => request()->time]);

        $this->generateIntensiveStudies($intensiveRequest);

        $teacherName = $teacher->name ?? $teacher->phone;
        $title = "تم الموفقة على طلبك في المسار المكثف";
        $message = "قام المعلم {$teacherName} بالموافقة على طلبك الانضمام الى المسار المكثف {$intensiveRequest->student->name}";
        sendNotification($intensiveRequest->student, [], 'accept-request', asset('assets/images/brand-logos/toggle-white.png'), $title, $message);

        return responseJson(new IntensiveRequestResource($intensiveRequest), __('messages.Updated Successfully'));
    }

    public function rejectSessionRequest($id)
    {
        $teacher = auth("teacher_api")->user();

        $intensiveRequest = IntensiveRequest::whereStatus(RequestActionEnum::WAITING)->whereTeacherId(auth('teacher_api')->id())->find($id);
        if (!$intensiveRequest)
            return responseJson("", __('messages.not_found'), 400);

        $intensiveRequest->update(['status' => RequestActionEnum::REJECT]);
        $teacherName = $teacher->name ?? $teacher->phone;
        $title = "تم رفض طلبك في المسار المكثف";
        $message = "قام المعلم {$teacherName} برفض طلبك الانضمام الى المسار المكثف {$intensiveRequest->student->name}";
        sendNotification($intensiveRequest->student, [], 'reject-request', asset('assets/images/brand-logos/toggle-white.png'), $title, $message);

        return responseJson("", __('messages.Updated Successfully'));
    }


    public function previousSessions()
    {
        $this->searchForSessionsRequest();
        $sessions = IntensiveSession::whereStatus(1)->whereTeacherId(auth("teacher_api")->id())->latest()->paginate(10);
        return responseJson(IntensiveSessionResource::collection($sessions->items()), '', 200, getPaginates($sessions));
    }

    public function nextSessions()
    {
        $this->searchForSessionsRequest();
        $sessions = IntensiveSession::whereStatus(0)->whereTeacherId(auth("teacher_api")->id())->latest()->paginate(10);
        return responseJson(IntensiveSessionResource::collection($sessions->items()), '', 200, getPaginates($sessions));
    }


    protected function searchForSessionsRequest()
    {
        if ($searchValue = request()->search)
            request()->merge([
                'search' => json_encode([
                    'searchKey' => $searchValue,
                    'searchInTranslations' => false,
                    'columns' => ['id'],
                    'searchInRelations' => [
                        [
                            'relation' => 'intensiveStudy.intensiveRequest.student',
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


    public function callStudent($id)
    {
        $teacher = auth("teacher_api")->user();
        $intensiveSession = IntensiveSession::whereStatus(0)->whereTeacherId(auth('teacher_api')->id())->where("date", "<=", now())->find($id);
        if (!$intensiveSession)
            return responseJson("", "هذه الجلسة لم يأتي موعدها حتى الان او ربما انتهت", 400);
        $agoraToken = generateAgoraToken($teacher, "intensive-session-" . $intensiveSession->id);

        $data["channal_name"] = "intensive-session";
        $data["channal_id"] = $intensiveSession->id;
        $data["caller_name"] = $teacher->name ?? $teacher->phone;
        $data["caller_image"] = $teacher->image . "";

        $intensiveSession->student->notify(new MessageNotification($data, 'call'));

        $teacherName = $teacher->name ?? $teacher->phone;
        $title = "تم الاتصال بك في المسار المكثف";
        $message = "قام المعلم {$teacherName} بالاتصال بك للانضمام  الى جلستك داخل المسار المكثف ";
        sendNotification($intensiveSession->intensiveStudy?->intensiveRequest?->student, [], 'call-student', asset('assets/images/brand-logos/toggle-white.png'), $title, $message);

        return responseJson($agoraToken, "جاري الاتصال بالطالب", 200);
    }

    public function surahs($id)
    {
        $intensiveSession = IntensiveSession::whereStatus(0)->where("date", "<=", now())->whereTeacherId(auth('teacher_api')->id())->find($id);
        if (!$intensiveSession)
            return responseJson("", "هذه الجلسة لم يأتي موعدها حتى الان او ربما انتهت", 400);

        $intensiveStudy = $intensiveSession->intensiveStudy;
        $data = Surah::where("id", '>=', $intensiveStudy->from_surah_id)->where("id", '<=', $intensiveStudy->to_surah_id)->get();
        return responseJson(SurahResource::collection($data));
    }
    public function endSession(SurahAndAyahRequest $request, $id)
    {
        $teacher = auth("teacher_api")->user();

        $intensiveSession = IntensiveSession::whereStatus(0)->where("date", "<=", now())->whereTeacherId(auth('teacher_api')->id())->find($id);
        if (!$intensiveSession)
            return responseJson("", "هذه الجلسة لم يأتي موعدها حتى الان او ربما انتهت", 400);

        $intensiveStudy = $intensiveSession->intensiveStudy;

        $intensiveSession->update([
            'status' => 1,
            "from_surah_id" => request()->from_surah_id,
            "to_surah_id" => request()->to_surah_id,
            "from_ayah_id" => request()->from_ayah_id,
            "to_ayah_id" => request()->to_ayah_id,
        ]);

        $tasme3 = $intensiveSession?->fromSurah?->name . " ( " . $intensiveSession?->fromAyah?->text . " )  الى " . $intensiveSession?->toSurah?->name . " ( " . $intensiveSession?->toAyah?->text . " ) ";

        //notification
        $teacherName = $teacher->name ?? $teacher->phone;
        $title = "تم انهاء جلستك داخل المسار المكثف";
        $message = "قام المعلم {$teacherName} بانهاء جلستك داخل المسار المكثف والتي كانت من " . $tasme3 . " من فضلك قم بتقييم المعلم";
        sendNotification($intensiveSession->intensiveStudy?->intensiveRequest?->student, [], 'call-student', asset('assets/images/brand-logos/toggle-white.png'), $title, $message);

        if ($intensiveStudy->to_ayah_id == request()->to_ayah_id) {
            $intensiveStudy->update(['is_completed' => 1]);
            StudentExam::create([
                "name" => "امتحان على خمسة اجزاء في المسار المكثف من  " . $intensiveStudy->fromSurah?->name . " ( " . $intensiveStudy->fromAyah?->text . " )  الى " . $intensiveStudy->toSurah?->name . " ( " . $intensiveStudy->toAyah?->text . " ) ",
                "student_id" => $intensiveStudy->intensiveRequest->student_id,
                "track_id" => 3,
                "model_id" => $intensiveSession->id,
                "model_type" => IntensiveSession::class,
            ]);

            //notification
            $title = "تم اضافة امتحان لك في المسار المكثف";
            $message = "لقد قمت بأتمام خمس اجزاء في المسار المكثف والان تم اضافة امتحان لك من فضلك قم بالذهاب الى صفحة الامتحانات";
            sendNotification($intensiveSession->intensiveStudy?->intensiveRequest?->student, [], 'exam-added', asset('assets/images/brand-logos/toggle-white.png'), $title, $message);

        } else {
            $dateTime = now()->addDay()->format("Y-m-d") . " " . $intensiveStudy->intensiveRequest?->time;
            IntensiveSession::create([
                'intensive_study_id' => $intensiveStudy->id,
                'date' => $dateTime
            ]);

        }

        return responseJson(new IntensiveRequestResource($intensiveSession), __('messages.Updated Successfully'));
    }


    public function rateStudent($id)
    {
        request()->validate(['comment' => 'nullable', 'rate' => 'required|integer|in:1,2,3,4,5']);
        $session = IntensiveSession::whereStatus(1)->whereRelation("intensiveStudy.intensiveRequest", "teacher_id", auth('teacher_api')->id())->find($id);
        if (!$session)
            return responseJson("", "هذه الجلسة لم تنتهي حتى الان", 400);

        $student = $session->intensiveStudy?->intensiveRequest?->student;

        if (Rating::whereRatedId($student->id)->whereRatedType(Student::class)->whereModelId($session->id)->whereModelType(IntensiveSession::class)->exists())
            return responseJson("", __('messages.You already rated this session before'), 404);

        Rating::create([
            "rate" => request()->rate,
            "comment" => request()->comment,
            "rated_id" => $student->id,
            "rated_type" => Student::class,
            "model_id" => $session->id,
            "model_type" => IntensiveSession::class,
            "ratedby_id" => auth('teacher_api')->id(),
            "ratedby_type" => Teacher::class,
        ]);

        if ($student)
            $student->update(['rate' => round($student->ratings()->avg('rate'), 1), 'number_of_rates' => $student->number_of_rates + 1]);

        return responseJson("", 'تم التقييم بنجاح');
    }

    private function generateIntensiveStudies($intensiveRequest)
    {
        $intensiveRequestId = $intensiveRequest->id;
        $preservationMethodId = $intensiveRequest->preservation_method_id;
        $parts = $preservationMethodId == 3
            ? range(1, 30)              // من الفاتحة إلى الناس
            : array_reverse(range(1, 30)); // من الناس إلى الفاتحة

        $chunks = array_chunk($parts, 5);

        foreach ($chunks as $key => $chunk) {
            $ayas = Ayah::whereIn('juz', $chunk)
                ->orderBy('id', $preservationMethodId == 3 ? 'asc' : 'desc')
                ->get();

            if ($ayas->isEmpty()) continue;

            $fromAyah = $preservationMethodId == 3 ? $ayas->first() : $ayas->last();
            $toAyah   = $preservationMethodId == 3 ? $ayas->last()  : $ayas->first();


            $study = IntensiveStudy::create([
                "status" => $key == 0 ? 1 : 0,
                "intensive_request_id" => $intensiveRequestId,
                'from_surah_id' => $fromAyah->surah_id,
                'to_surah_id' => $toAyah->surah_id,
                'from_ayah_id' => $fromAyah->id,
                'to_ayah_id' => $toAyah->id,
            ]);

            if ($key == 0) {
                $dateTime = now()->addDay()->format("Y-m-d") . " " . request()->time;
                IntensiveSession::create([
                    'intensive_study_id' => $study->id,
                    'date' => $dateTime
                ]);
            }
        }
    }
}
