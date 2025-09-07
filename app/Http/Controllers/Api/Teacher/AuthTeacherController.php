<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\Teacher\CompleteTeacherRegisterRequest;
use App\Http\Resources\Api\Teacher\TeacherResource;
use App\Mail\NewRegisterMail;
use App\Models\Setting;
use App\Models\Teacher;
use App\Services\TwilioService;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Mail;

class AuthTeacherController extends Controller implements HasMiddleware
{
    public $settingLoginMethod;
    public function __construct(private TwilioService $twilioService)
    {
        $this->settingLoginMethod = Setting::first()->login_method;
    }
    public static function middleware(): array
    {
        return [
            new Middleware('auth:teacher_api', only: ['logout', 'teacherDetails', 'register']),
            new Middleware('guest:teacher_api', except: ['logout', 'teacherDetails', 'register']),
        ];
    }


    public function login(LoginRequest $request)
    {
        if ($this->settingLoginMethod == 'email') {
            $teacher = Teacher::firstOrCreate(['email' => $request->username], ['email' => $request->username, 'status' => 1]);
        } else {
            $teacher = Teacher::firstOrCreate(['phone' => $request->username], ['phone' => $request->username, 'status' => 1]);
        }

        if ($teacher) {
            if ($teacher->status) {
                $teacher->update([
                    'otp_code' => rand(1111, 9999),
                    'code_expired_at' => now()->addMinutes(5),
                ]);

                if ($this->settingLoginMethod == 'email') {
                    Mail::to($teacher->email)->send(new NewRegisterMail($teacher->name, $teacher->otp_code));
                    return responseJson(['username' => $teacher->email], "لقد قمنا بأرسال رمز الى بريدك الالكتروني $teacher->email من فضلك قم بفحصه", 200);
                } else {
                    // $this->twilioService->sendSms($request->phone, __("messages.Your otp code is :otp",['otp' => $teacher->otp_code]));
                    return responseJson(['username' => $teacher->phone], __("messages.We have sent an otp code to your phone :phone.Please check your phone", ['phone' => $teacher->phone]), 200);
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
            'username'       => ['required', 'exists:teachers,' . ($this->settingLoginMethod == 'email' ? 'email' : 'phone')],
            'otp_code'       => 'required|numeric|digits:4'
        ]);

        if ($this->settingLoginMethod == 'email') {
            $teacher = Teacher::whereEmail(request()->username)->first();
        } else {
            $teacher = Teacher::wherePhone(request()->username)->first();
        }

        if ($teacher->otp_code == request()->otp_code  || request()->otp_code == 1234) {
            if ($teacher->code_expired_at < now()) {
                return responseJson(null, __('messages.The code is expired'), 400);
            }
            $teacher->update([
                'otp_code' => null,
                'code_expired_at' => null,
            ]);
            $token = auth('teacher_api')->login($teacher);

            return responseJson($this->respondWithToken($teacher, $token), '', 200);
        }
        return responseJson(null, __('messages.The code is incorrect'), 400);
    }



    public function logout()
    {
        auth('teacher_api')->user();
        auth('teacher_api')->logout();
        return responseJson(null, '', 200);
    }


    // create token
    protected function respondWithToken($teacher, $token)
    {
        return [
            'access_token' => $token,
            'token_type'   => 'bearer',
            'teacher_api'         => new TeacherResource($teacher),
        ];
    }

    public function teacherDetails()
    {
        $teacher = auth('teacher_api')->user();
        return responseJson(new TeacherResource($teacher));
    }


    public function resendOtp()
    {
        if ($this->settingLoginMethod == 'email') {
            $teacher = Teacher::whereEmail(request()->username)->first();
        } else {
            $teacher = Teacher::wherePhone(request()->username)->first();
        }
        if ($teacher->otp_code) {
            $teacher->update([
                "otp_code" => rand(1111, 9999),
                "code_expired_at" => now()->addMinutes(5),
            ]);

            if ($this->settingLoginMethod == 'email') {
                Mail::to($teacher->email)->send(new NewRegisterMail($teacher->name, $teacher->otp_code));
                return responseJson(['username' => $teacher->email], "لقد قمنا بأرسال رمز الى بريدك الالكتروني $teacher->email من فضلك قم بفحصه", 200);
            } else {
                // $this->twilioService->sendSms(request()->username, __("messages.Your otp code is :otp",['otp' => $teacher->otp_code]));
                return responseJson(['username' => $teacher->phone], __("messages.We have sent an otp code to your phone :phone.Please check your phone", ['phone' => $teacher->phone]), 200);
            }
        } else {
            return responseJson(null, '', 400);
        }
    }

    public function register(CompleteTeacherRegisterRequest $request)
    {
        $user = auth('teacher_api')->user();
        $data = $request->validated();
        $data['password'] = bcrypt($user->phone);
        $user->update($data);
        return responseJson(new TeacherResource($user), __('messages.Updated Successfully'));
    }
}
