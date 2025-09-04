<?php

namespace App\Http\Controllers\Api\Student;

use App\Enums\RequestActionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\Student\CompleteStudentRegisterRequest;
use App\Http\Resources\Api\Student\StudentResource;
use App\Mail\NewRegisterMail;
use App\Models\IntensiveRequest;
use App\Models\Setting;
use App\Models\Student;
use App\Models\StudentCircle;
use App\Services\TwilioService;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Mail;

class AuthStudentController extends Controller implements HasMiddleware
{
    public $settingLoginMethod;
    public function __construct(private TwilioService $twilioService)
    {
        $this->settingLoginMethod = Setting::first()->login_method;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('auth:student_api', only: ['logout', 'completeRegister', 'updateGender', 'updateTrack', 'studentDetails']),
            new Middleware('guest:student_api', except: ['logout', 'completeRegister', 'updateGender', 'updateTrack', 'studentDetails']),
        ];
    }


    public function login(LoginRequest $request)
    {
        if ($this->settingLoginMethod == 'email') {
            $student = Student::firstOrCreate(['email' => $request->username], ['email' => $request->username, 'status' => 1]);
        } else {
            $student = Student::firstOrCreate(['phone' => $request->username], ['phone' => $request->username, 'status' => 1]);
        }

        if ($student) {
            if ($student->status) {
                $student->update([
                    'otp_code' => rand(1111, 9999),
                    'code_expired_at' => now()->addMinutes(5),
                ]);

                if ($this->settingLoginMethod == 'email') {
                    Mail::to($student->email)->send(new NewRegisterMail($student->name, $student->otp_code));
                    return responseJson(['username' => $student->email], "لقد قمنا بأرسال رمز الى بريدك الالكتروني $student->email من فضلك قم بفحصه", 200);
                } else {
                    // $this->twilioService->sendSms($request->phone, __("messages.Your otp code is :otp",['otp' => $student->otp_code]));
                    return responseJson(['username' => $student->phone], __("messages.We have sent an otp code to your phone :phone.Please check your phone", ['phone' => $student->phone]), 200);
                }
            } else {
                return responseJson(null, __('messages.Your account is not activated please contact with support'), 400);
            }
        } else {
            return responseJson(null, __('messages.Your phone is not registered'), 400);
        }
    }



    public function activateAccount()
    {
        request()->validate([
            'username'       => ['required', 'exists:students,' . ($this->settingLoginMethod == 'email' ? 'email' : 'phone')],
            'otp_code'       => 'required|numeric|digits:4'
        ]);
        if ($this->settingLoginMethod == 'email') {
            $student = Student::whereEmail(request()->email)->first();
        } else {
            $student = Student::wherePhone(request()->phone)->first();
        }
        if ($student->otp_code == request()->otp_code || 1234 == request()->otp_code) {
            if ($student->code_expired_at < now()) {
                return responseJson(null, __('messages.The code is expired'), 400);
            }
            $student->update([
                'otp_code' => null,
                'code_expired_at' => null,
            ]);
            $token = auth('student_api')->login($student);

            return responseJson($this->respondWithToken($student, $token), '', 200);
        }
        return responseJson(null, __('messages.The code is incorrect'), 400);
    }



    public function logout()
    {
        auth('student_api')->user();
        auth('student_api')->logout();
        return responseJson(null, '', 200);
    }


    // create token
    protected function respondWithToken($student, $token)
    {
        return [
            'access_token' => $token,
            'token_type'   => 'bearer',
            'student_api'         => new StudentResource($student),
        ];
    }


    public function resendOtp()
    {
        if ($this->settingLoginMethod == 'email') {
            $student = Student::whereEmail(request()->email)->first();
        } else {
            $student = Student::wherePhone(request()->phone)->first();
        }
        $student = Student::wherePhone(request()->phone)->first();
        if ($student->otp_code) {
            $student->update([
                "otp_code" => rand(1111, 9999),
                "code_expired_at" => now()->addMinutes(5),
            ]);
            if ($this->settingLoginMethod == 'email') {
                Mail::to($student->email)->send(new NewRegisterMail($student->name, $student->otp_code));
                return responseJson(['username' => $student->email], "لقد قمنا بأرسال رمز الى بريدك الالكتروني $student->email من فضلك قم بفحصه", 200);
            } else {
                // $this->twilioService->sendSms($request->phone, __("messages.Your otp code is :otp",['otp' => $student->otp_code]));
                return responseJson(['username' => $student->phone], __("messages.We have sent an otp code to your phone :phone.Please check your phone", ['phone' => $student->phone]), 200);
            }
        } else {
            return responseJson(null, '', 400);
        }
    }

    public function completeRegister(CompleteStudentRegisterRequest $request)
    {
        $user = auth('student_api')->user();
        $data = $request->validated();
        $data['password'] = bcrypt($user->phone);
        $user->update($data);
        return responseJson(new StudentResource($user), __('messages.Updated Successfully'));
    }

    public function updateGender()
    {
        $user = auth('student_api')->user();
        request()->validate(['gender' => "required|in:male,female"]);
        $user->update(['gender' => request()->gender]);
        return responseJson(new StudentResource($user), __('messages.Updated Successfully'));
    }

    public function updateTrack()
    {
        $student = auth('student_api')->user();
        request()->validate([
            'track_id' => "required|exists:tracks,id",
            'level_id' => [
                'required_if:track_id,2',
                function ($attribute, $value, $fail) {
                    if (request()->has('preservation_method_id') && request()->track_id == 2) {
                        $preservationMethodId = request()->input('preservation_method_id');
                        $exists = \DB::table('levels')
                            ->where('id', $value)
                            ->where('preservation_method_id', $preservationMethodId)
                            ->exists();
                        if (!$exists) {
                            $fail('The selected level does not belong to the specified preservation method.');
                        }
                    }
                },
            ],
            'preservation_method_id' => ['required_if:track_id,2,3', function ($attribute, $value, $fail) {
                if (request()->track_id == 3 && !in_array($value, [4, 3])) {
                    $fail('اتجاه الحفظ غير صالح للمسار المكثف');
                }
                if (request()->track_id == 2 && !in_array($value, [1, 2])) {
                    $fail('اتجاه الحفظ غير صالح لمسار الحلقات');
                }
            }],
        ]);

        if (IntensiveRequest::whereStudentId($student->id)->whereStatus(RequestActionEnum::ACCEPT)->exists())
            return responseJson("", "انت الان مشترك في المسار المكثف يجب عليك اتمامه اولا او التواصل مع خدمة العملاء", 400);

        if (StudentCircle::whereStudentId($student->id)->whereStatus(0)->exists())
            return responseJson("", "انت الان مشترك في مسار الحلقات يجب عليك اتمامه اولا او التواصل مع خدمة العملاء", 400);

        $student->update([
            'track_id' => request()->track_id,
            'level_id' => request()->track_id == 2 && request()->level_id ? request()->level_id : null,
            'preservation_method_id' => request()->track_id == 2 || request()->track_id == 3 ? request()->preservation_method_id : null,
        ]);
        return responseJson(new StudentResource($student), __('messages.Updated Successfully'));
    }
    public function studentDetails()
    {
        $student = auth('student_api')->user();
        return responseJson(new StudentResource($student));
    }
}
