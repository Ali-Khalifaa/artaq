<?php

use App\Http\Controllers\Api\Student\AuthStudentController;
use App\Http\Controllers\Api\GeneralController;
use App\Http\Controllers\Api\Student\HomeController;
use App\Http\Controllers\Api\Student\NotificationController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Middleware\ChangeLang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:student_api');


Route::group(['prefix' => 'student', 'middleware' => [ChangeLang::class]], function () {


    Route::post('login', [AuthStudentController::class, 'login']);
    Route::post('verify-otp', [AuthStudentController::class, 'activateAccount']);
    Route::post('resend-otp', [AuthStudentController::class, 'resendOtp']);



    Route::get('get-language', [SettingController::class, 'getLanguage']);

    Route::group(['middleware' => 'auth:student_api'], function () {

        Route::post('logout', [AuthStudentController::class, 'logout']);
        Route::post('complete-register', [AuthStudentController::class, 'completeRegister']);

        Route::get('tracks', [HomeController::class, 'tracks']);
        Route::get('preservation-methods', [HomeController::class, 'preservationMethods']);
        Route::get('levels', [HomeController::class, 'levels']);
        Route::get('memorization-amount', [HomeController::class, 'memorizationAmount']);
        Route::get('nationalities', [GeneralController::class, 'nationalities']);
        Route::get('countries', [GeneralController::class, 'countries']);
        Route::get('cities', [GeneralController::class, 'cities']);


        Route::controller(NotificationController::class)->group(function () {
            Route::get('all-notifications', 'getAllNot');
            Route::get('unread-notifications', 'getNotReadNotifications');
            Route::post('clear-notification-item/{id}', 'clearItem');
            Route::post('clear-all-notifications', 'clearAll');
            Route::post('delete-notification-item/{id}', 'deleteItem');
            Route::post('delete-all-notifications', 'deleteAll');
        });

        // Route::put('update-admin-profile', [ProfileController::class,'updateAdminProfile']);
    });
});
