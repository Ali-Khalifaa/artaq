<?php

use App\Http\Controllers\Api\ChatChannelController;
use App\Http\Controllers\Api\Student\AuthStudentController;
use App\Http\Controllers\Api\GeneralController;
use App\Http\Controllers\Api\Student\FreeSessionsController;
use App\Http\Controllers\Api\Student\HomeController;
use App\Http\Controllers\Api\Student\IntensiveSessionsController;
use App\Http\Controllers\Api\Student\NotificationController;
use App\Http\Controllers\Api\Student\StudentCircleController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Middleware\ChangeLang;
use App\Http\Middleware\ResolveJwtGuard;
use Illuminate\Broadcasting\BroadcastController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;






Route::group(['middleware' => [ChangeLang::class]], function () {

    //general
    Route::get('tracks', [GeneralController::class, 'tracks']);
    Route::get('preservation-methods', [GeneralController::class, 'preservationMethods']);
    Route::get('levels', [GeneralController::class, 'levels']);
    Route::get('memorization-amount', [GeneralController::class, 'memorizationAmount']);
    Route::get('nationalities', [GeneralController::class, 'nationalities']);
    Route::get('countries', [GeneralController::class, 'countries']);
    Route::get('cities', [GeneralController::class, 'cities']);
    Route::get('surahs', [GeneralController::class, 'surahs']);
    Route::get('ayahs', [GeneralController::class, 'ayahs']);
    Route::get('login-method', [GeneralController::class, 'getSettingLoginMethod']);

    Route::post('login', [GeneralController::class, 'login']);
    Route::post('verify-otp', [GeneralController::class, 'activateAccount']);
    Route::post('resend-otp', [GeneralController::class, 'resendOtp']);

    Route::group(['middleware' => [ResolveJwtGuard::class]], function () {
        Route::get('get-channels', [ChatChannelController::class, 'getChannels']);
        Route::get('get-messages/{chatChannel}', [ChatChannelController::class, 'getMessages']);
        Route::post('send-message', [ChatChannelController::class, 'sendMessage']);
        Route::post('create-or-get-channel/{modelId}', [ChatChannelController::class, 'createOrGetChannel']);
        Route::post('broadcasting/auth', [BroadcastController::class, 'authenticate']);
        Route::post('logout', [GeneralController::class, 'logout']);
        Route::post('delete-account', [GeneralController::class, 'deleteAccount']);

    });

    Route::group(['prefix' => 'student'], function () {


        // Route::post('login', [AuthStudentController::class, 'login']);
        // Route::post('verify-otp', [AuthStudentController::class, 'activateAccount']);
        // Route::post('resend-otp', [AuthStudentController::class, 'resendOtp']);



        Route::get('get-language', [SettingController::class, 'getLanguage']);

        Route::group(['middleware' => 'auth:student_api'], function () {


            Route::post('accept-call', [HomeController::class, 'acceptCall']);
            Route::get('next-exam', [HomeController::class, 'getNextExam']);
            Route::get('prev-exams', [HomeController::class, 'getPrevExams']);
            Route::get('digital-badges', [HomeController::class, 'digitalBadges']);
            Route::get('certificates', [HomeController::class, 'certificates']);

            Route::post('logout', [AuthStudentController::class, 'logout']);

            Route::get('student-details', [AuthStudentController::class, 'studentDetails']);
            Route::post('complete-register', [AuthStudentController::class, 'completeRegister']);
            Route::post('update-gender', [AuthStudentController::class, 'updateGender']);
            Route::post('update-track', [AuthStudentController::class, 'updateTrack']);


            Route::get('get-all-teachers', [FreeSessionsController::class, 'getAllTeachers']);
            Route::get('active-teachers', [FreeSessionsController::class, 'getActiveTeachers']);
            Route::get('current-session', [FreeSessionsController::class, 'getCurrentSession']);
            Route::get('previous-sessions', [FreeSessionsController::class, 'previousSessions']);
            Route::get('last-session-details', [FreeSessionsController::class, 'lastSessionDetails']);
            Route::get('sessions-details', [FreeSessionsController::class, 'freeSessionsDetails']);
            Route::post('start-session/{teacherId}', [FreeSessionsController::class, 'startSession']);
            // Route::post('accept-call', [FreeSessionsController::class, 'acceptCall']); /////////
            Route::post('rate-teacher-session/{id}', [FreeSessionsController::class, 'rateTeacher']);


            //intensive sessions
            Route::group(['prefix' => 'intensive'], function () {

                Route::get('get-active-teachers', [IntensiveSessionsController::class, 'getActiveTeachers']);
                Route::post('send-intensive-request/{teacherId}', [IntensiveSessionsController::class, 'sendSessionRequest']);
                Route::get('current-intensive-requests', [IntensiveSessionsController::class, 'getCurrentIntensiveRquest']);
                Route::get('previous-intensive-sessions', [IntensiveSessionsController::class, 'previousSessions']);
                Route::get('next-intensive-session', [IntensiveSessionsController::class, 'nextSession']);
                Route::get('intensive-session-details', [IntensiveSessionsController::class, 'lastSessionDetails']);
                Route::post('rate-teacher-intensivesession/{intensiveSessionId}', [IntensiveSessionsController::class, 'rateTeacher']);
                Route::post('accept-intensive-session-call/{channelName}', [IntensiveSessionsController::class, 'acceptCall']);
                Route::post('join-intensive-session-call/{intensiveSessionId}', [IntensiveSessionsController::class, 'joinCall']);
            });

            Route::group(['prefix' => 'circles-sessions'], function () {

                Route::get('current-devel-details', [StudentCircleController::class, 'currentLevelDetails']);
                Route::get('get-next-session', [StudentCircleController::class, 'getNextSession']);
                Route::get('current-circle-session', [StudentCircleController::class, 'currentCircleSession']);
                Route::get('circle-schedual', [StudentCircleController::class, 'getCircleSchedual']);
                Route::get('previous-sessions', [StudentCircleController::class, 'previousSessions']);
                Route::post('rate-teacher/{studentLevelTask}', [StudentCircleController::class, 'rateTeacher']);

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
});
