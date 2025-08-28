<?php

use App\Http\Controllers\Api\Parent\AuthParentController;
use App\Http\Controllers\Api\Parent\NotificationController;
use App\Http\Controllers\Api\Parent\StudentParentSessionController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Middleware\ChangeLang;
use Illuminate\Support\Facades\Route;






Route::group(['middleware' => [ChangeLang::class]], function () {



    Route::group(['prefix' => 'parent'], function () {


        Route::get('get-language', [SettingController::class, 'getLanguage']);

        Route::group(['middleware' => 'auth:parent_api'], function () {




            Route::get('prev-free-sessions/{studentId}', [StudentParentSessionController::class, 'previousFreeSessions']);
            Route::get('prev-intensive-sessions/{studentId}', [StudentParentSessionController::class, 'previousIntensiveSessions']);
            Route::get('next-intensive-session/{studentId}', [StudentParentSessionController::class, 'nextIntensiveSession']);
            Route::get('next-circle-session/{studentId}', [StudentParentSessionController::class, 'nextCircleSession']);
            Route::get('prev-circle-sessions/{studentId}', [StudentParentSessionController::class, 'previousCircleSessions']);
            Route::get('get-next-exam/{studentId}', [StudentParentSessionController::class, 'getNextExam']);
            Route::get('get-prev-exams/{studentId}', [StudentParentSessionController::class, 'getPrevExams']);
            Route::get('circle-sessions-attends/{studentId}', [StudentParentSessionController::class, 'circleSessionsAttends']);

            Route::get('students', [AuthParentController::class, 'students']);
            Route::post('logout', [AuthParentController::class, 'logout']);




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
});
