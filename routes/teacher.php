<?php

use App\Http\Controllers\Api\Teacher\AuthTeacherController;
use App\Http\Controllers\Api\GeneralController;
use App\Http\Controllers\Api\Teacher\NotificationController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Middleware\ChangeLang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:student_api');


Route::group(['prefix' => 'student', 'middleware' => [ChangeLang::class]], function () {


    Route::post('login', [AuthTeacherController::class, 'login']);
    Route::post('activateAccount', [AuthTeacherController::class, 'activateAccount']);
    Route::post('resendOtp', [AuthTeacherController::class, 'resendOtp']);
    Route::post('register', [AuthTeacherController::class, 'register']);


    Route::get('get-language', [SettingController::class, 'getLanguage']);

    Route::group(['middleware' => 'auth:student_api'], function () {

        Route::post('logout', [AuthTeacherController::class, 'logout']);


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
