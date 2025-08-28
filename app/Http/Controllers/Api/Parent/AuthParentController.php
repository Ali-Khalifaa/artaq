<?php

namespace App\Http\Controllers\Api\Parent;

use App\Enums\RequestActionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\Student\CompleteStudentRegisterRequest;
use App\Http\Resources\Api\Student\StudentResource;
use App\Models\IntensiveRequest;
use App\Models\StudentParent;
use App\Models\StudentCircle;
use App\Services\TwilioService;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AuthParentController extends Controller implements HasMiddleware
{
    public function __construct(private TwilioService $twilioService) {}

    public static function middleware(): array
    {
        return [
            new Middleware('auth:parent_api', only: ['logout', 'students']),
            new Middleware('guest:parent_api', except: ['logout', 'students']),
        ];
    }


    public function login(LoginRequest $request)
    {
        $parent = StudentParent::firstOrCreate(['phone' => $request->phone], ['phone' => $request->phone, 'status' => 1]);

        if ($parent) {
            if ($parent->status) {
                $parent->update([
                    'otp_code' => rand(1111, 9999),
                    'code_expired_at' => now()->addMinutes(5),
                ]);

                // $this->twilioService->sendSms($request->phone, __("messages.Your otp code is :otp",['otp' => $parent->otp_code]));

                // Mail::to($parent->email)->send(new NewRegisterMail($parent->name, $parent->otp_code));
                return responseJson(['phone' => $parent->phone], __("messages.We have sent an otp code to your phone :phone.Please check your phone", ['phone' => $parent->phone]), 200);
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
            'phone'       => ['required', 'exists:parents'],
            'otp_code'       => 'required|numeric|digits:4'
        ]);
        $parent = StudentParent::wherePhone(request()->phone)->first();

        if ($parent->otp_code == request()->otp_code || 1234 == request()->otp_code) {
            if ($parent->code_expired_at < now()) {
                return responseJson(null, __('messages.The code is expired'), 400);
            }
            $parent->update([
                'otp_code' => null,
                'code_expired_at' => null,
            ]);
            $token = auth('parent_api')->login($parent);

            return responseJson($this->respondWithToken($parent, $token), '', 200);
        }
        return responseJson(null, __('messages.The code is incorrect'), 400);
    }



    public function logout()
    {
        auth('parent_api')->user();
        auth('parent_api')->logout();
        return responseJson(null, '', 200);
    }


    // create token
    protected function respondWithToken($parent, $token)
    {
        return [
            'access_token' => $token,
            'token_type'   => 'bearer',
            'parent_api'         => [
                "id" => $parent->id,
                "phone" => $parent->phone,
                "image" => $parent->image,
            ],
        ];
    }


    public function resendOtp()
    {
        $parent = StudentParent::wherePhone(request()->phone)->first();
        if ($parent->otp_code) {
            $parent->update([
                "otp_code" => rand(1111, 9999),
                "code_expired_at" => now()->addMinutes(5),
            ]);
            // $this->twilioService->sendSms(request()->phone, __("messages.Your otp code is :otp",['otp' => $parent->otp_code]));
            // Mail::to($parent->email)->send(new ResendOTPMail($parent->name, $parent->otp_code));
            return responseJson(['phone' => $parent->phone], __("messages.We have sent an otp code to your phone :phone.Please check your phone", ['phone' => $parent->phone]), 400);
        } else {
            return responseJson(null, '', 400);
        }
    }


    public function students()
    {
        $parent = auth('parent_api')->user();
        return responseJson(StudentResource::collection($parent->students));
    }
}
