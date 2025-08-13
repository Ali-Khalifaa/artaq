<?php

use App\Http\Controllers\Api\Teacher\AuthTeacherController;
use App\Http\Controllers\Api\GeneralController;
use App\Http\Controllers\Api\Teacher\FreeSessionsController;
use App\Http\Controllers\Api\Teacher\HomeController;
use App\Http\Controllers\Api\Teacher\IntensiveSessionsController;
use App\Http\Controllers\Api\Teacher\NotificationController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Middleware\ChangeLang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'teacher', 'middleware' => [ChangeLang::class]], function () {


    // Route::post('login', [AuthTeacherController::class, 'login']);
    // Route::post('verify-otp', [AuthTeacherController::class, 'activateAccount']);
    // Route::post('resend-otp', [AuthTeacherController::class, 'resendOtp']);


    Route::get('get-language', [SettingController::class, 'getLanguage']);

    Route::group(['middleware' => 'auth:teacher_api'], function () {

        Route::get('teacher-details', [AuthTeacherController::class, 'teacherDetails']);
        Route::post('register', [AuthTeacherController::class, 'register']);
        Route::post('logout', [AuthTeacherController::class, 'logout']);
        Route::post('update-work-status', [HomeController::class, 'updateWorkStatus']);
        Route::get('current-session', [FreeSessionsController::class, 'getCurrentSession']);
        Route::get('get-session-requests', [FreeSessionsController::class, 'getFreeSessionRequests']);
        Route::post('accept-session/{id}', [FreeSessionsController::class, 'acceptSessionRequest']);
        Route::post('end-session/{id}', [FreeSessionsController::class, 'endSession']);
        Route::post('rate-student-session/{id}', [FreeSessionsController::class, 'rateStudent']);



        //intensive sessions
        Route::group(['prefix' => 'intensive'], function () {
            Route::get('get-intensive-requests', [IntensiveSessionsController::class, 'getIntensiveRequests']);
            Route::get('get-active-intensives', [IntensiveSessionsController::class, 'getActiveIntensiveRequests']);
            Route::post('accept-intensive-request/{intensiveRequestId}', [IntensiveSessionsController::class, 'acceptSessionRequest']);
            Route::post('reject-intensive-request/{intensiveRequestId}', [IntensiveSessionsController::class, 'rejectSessionRequest']);
            Route::get('previous-sessions', [IntensiveSessionsController::class, 'previousSessions']);
            Route::get('next-sessions', [IntensiveSessionsController::class, 'nextSessions']);
            Route::post('call-student/{IntensiveSession}', [IntensiveSessionsController::class, 'callStudent']);
            Route::post('end-session/{IntensiveSession}', [IntensiveSessionsController::class, 'endSession']);
            Route::post('rate-student/{IntensiveSession}', [IntensiveSessionsController::class, 'rateStudent']);
            Route::get('surahs/{IntensiveSession}', [IntensiveSessionsController::class, 'surahs']);

        });


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
