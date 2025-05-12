<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\LoginRequest;
use App\Http\Resources\Dashboard\AdminResource;
use App\Http\Resources\Dashboard\PermissionResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthDashboardController extends Controller
{

    public function login(LoginRequest $request)
    {
        $credentials = $request->only("email", "password");

        if ($token = Auth::guard('admin_api')->attempt($credentials)) {

            $user = Auth::guard('admin_api')->user();

            if($user->status == 1){
                return responseJson($this->respondWithToken($token),'Data exited successfully',200);
            }else{
                return responseJson(null,__('messages.YourEmailPassword'),404);
            }
        }else{
            return responseJson(null,__('messages.YourEmailPassword'),404);
        }

    }


    public function logout(Request $request) {
        auth()->guard('admin_api')->logout();
        return responseJson([],'Admin successfully signed out',200);
    }


    public function authorizeUser()
    {
        $user = auth()->guard('admin_api')->check();

        if($user){
            $permission = PermissionResource::collection((auth()->guard('admin_api')->user()->getAllPermissions()));
            return responseJson(['permission'=>$permission,'user'=>new AdminResource(auth()->guard('admin_api')->user())],'Data exited successfully',200);
        }else{
            return responseJson([],'',404);
        }
    }


    // create token
    protected function respondWithToken($token)
    {

        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => new AdminResource(auth()->guard('admin_api')->user()),
            'permission' =>  PermissionResource::collection((auth()->guard('admin_api')->user()->getAllPermissions()))
        ];

    }
}
