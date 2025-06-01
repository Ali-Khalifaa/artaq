<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Resources\Api\StudentResource;
use App\Models\Student;
use App\Services\TwilioService;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AuthMobileController extends Controller implements HasMiddleware
{
    public function __construct(private TwilioService $twilioService){}

    public static function middleware(): array
    {
        return [
            new Middleware('auth:student_api', only: ['logout']),
            new Middleware('guest:student_api', except: ['logout']),
        ];
    }


    public function login(LoginRequest $request)
    {
        $student = Student::firstOrCreate(['phone' => $request->phone],['phone' => $request->phone]);

        if ($student) {
            if ($student->status) {
                $student->update([
                    'otp_code' => rand(1111, 9999),
                    'code_expired_at' => now()->addMinutes(5),
                ]);

                $this->twilioService->sendSms($request->phone, __("messages.Your otp code is :otp",['otp' => $student->otp_code]));

                // Mail::to($student->email)->send(new NewRegisterMail($student->name, $student->otp_code));
                return responseJson(['phone' => $student->phone], __("messages.We have sent an otp code to your phone :phone.Please check your phone", ['phone' => $student->phone]), 400);
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
            'phone'       => ['required','exists:students'],
            'otp_code'       => 'required|numeric|digits:4'
        ]);
        $student = Student::wherePhone(request()->phone)->first();

        if ($student->otp_code == request()->otp_code) {
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
        $student = Student::wherePhone(request()->phone)->first();
        if ($student->otp_code) {
            $student->update([
                "otp_code" => rand(1111, 9999),
                "code_expired_at" => now()->addMinutes(5),
            ]);
            $this->twilioService->sendSms(request()->phone, __("messages.Your otp code is :otp",['otp' => $student->otp_code]));
            // Mail::to($student->email)->send(new ResendOTPMail($student->name, $student->otp_code));
                return responseJson(['phone' => $student->phone], __("messages.We have sent an otp code to your phone :phone.Please check your phone", ['phone' => $student->phone]), 400);
        }else{
            return responseJson(null,'',400);
        }
    }
}
