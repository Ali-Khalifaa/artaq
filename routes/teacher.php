<?php

use App\Http\Controllers\Api\Teacher\AuthTeacherController;
use App\Http\Controllers\Api\GeneralController;
use App\Http\Controllers\Api\Teacher\FreeSessionsController;
use App\Http\Controllers\Api\Teacher\HomeController;
use App\Http\Controllers\Api\Teacher\NotificationController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Middleware\ChangeLang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'teacher', 'middleware' => [ChangeLang::class]], function () {


    Route::post('login', [AuthTeacherController::class, 'login']);
    Route::post('verify-otp', [AuthTeacherController::class, 'activateAccount']);
    Route::post('resend-otp', [AuthTeacherController::class, 'resendOtp']);
    Route::post('register', [AuthTeacherController::class, 'register']);


    Route::get('get-language', [SettingController::class, 'getLanguage']);

    Route::group(['middleware' => 'auth:teacher_api'], function () {

        Route::get('teacher-details', [AuthTeacherController::class, 'teacherDetails']);
        Route::post('logout', [AuthTeacherController::class, 'logout']);
        Route::post('update-work-status', [HomeController::class, 'updateWorkStatus']);
        Route::get('get-session-requests', [FreeSessionsController::class, 'getFreeSessionRequests']);///////
        Route::post('accept-session/{id}', [FreeSessionsController::class, 'acceptSessionRequest']);///////
        Route::post('end-session/{id}', [FreeSessionsController::class, 'endSession']);///////
        Route::post('rate-student-session/{id}', [FreeSessionsController::class, 'rateStudent']);///////


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
