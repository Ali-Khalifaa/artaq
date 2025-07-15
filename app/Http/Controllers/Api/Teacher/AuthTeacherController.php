<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Resources\Api\Teacher\TeacherResource;
use App\Models\Teacher;
use App\Services\TwilioService;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AuthTeacherController extends Controller implements HasMiddleware
{
    public function __construct(private TwilioService $twilioService){}

    public static function middleware(): array
    {
        return [
            new Middleware('auth:teacher_api', only: ['logout']),
            new Middleware('guest:teacher_api', except: ['logout']),
        ];
    }


    public function login(LoginRequest $request)
    {
        $teacher = Teacher::firstOrCreate(['phone' => $request->phone],['phone' => $request->phone]);

        if ($teacher) {
            if ($teacher->status) {
                $teacher->update([
                    'otp_code' => rand(1111, 9999),
                    'code_expired_at' => now()->addMinutes(5),
                ]);

                $this->twilioService->sendSms($request->phone, __("messages.Your otp code is :otp",['otp' => $teacher->otp_code]));

                // Mail::to($teacher->email)->send(new NewRegisterMail($teacher->name, $teacher->otp_code));
                return responseJson(['phone' => $teacher->phone], __("messages.We have sent an otp code to your phone :phone.Please check your phone", ['phone' => $teacher->phone]), 400);
            }
            else {
                return responseJson(null, __('messages.Your account is not activated please contact with support'), 400);
            }
        } else {
            return responseJson(null, __('messages.Your phone is not registered'), 400);
        }
    }



    public function activateAccount()
    {
        request()->validate([
            'phone'       => ['required','exists:teachers'],
            'otp_code'       => 'required|numeric|digits:4'
        ]);
        $teacher = Teacher::wherePhone(request()->phone)->first();

        if ($teacher->otp_code == request()->otp_code) {
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


    public function resendOtp()
    {
        $teacher = Teacher::wherePhone(request()->phone)->first();
        if ($teacher->otp_code) {
            $teacher->update([
                "otp_code" => rand(1111, 9999),
                "code_expired_at" => now()->addMinutes(5),
            ]);
            $this->twilioService->sendSms(request()->phone, __("messages.Your otp code is :otp",['otp' => $teacher->otp_code]));
            // Mail::to($teacher->email)->send(new ResendOTPMail($teacher->name, $teacher->otp_code));
                return responseJson(['phone' => $teacher->phone], __("messages.We have sent an otp code to your phone :phone.Please check your phone", ['phone' => $teacher->phone]), 400);
        }else{
            return responseJson(null,'',400);
        }
    }
}
