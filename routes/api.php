<?php

use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\AuthDashboardController;
use App\Http\Controllers\Dashboard\BackupController;
use App\Http\Controllers\Dashboard\BannerController;
use App\Http\Controllers\Dashboard\CircleController;
use App\Http\Controllers\Dashboard\CircleTypeController;
use App\Http\Controllers\Dashboard\CityController;
use App\Http\Controllers\Dashboard\CountryController;
use App\Http\Controllers\Dashboard\DashboardStatisticsController;
use App\Http\Controllers\Dashboard\DigitalBadgeController;
use App\Http\Controllers\Dashboard\JoinUsController;
use App\Http\Controllers\Dashboard\LanguageController;
use App\Http\Controllers\Dashboard\LevelController;
use App\Http\Controllers\Dashboard\MemorizationAmountController;
use App\Http\Controllers\Dashboard\MemorizationTypeController;
use App\Http\Controllers\Dashboard\NationalityController;
use App\Http\Controllers\Dashboard\NotificationController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\SendNotificationController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\StudentController;
use App\Http\Controllers\Dashboard\TeacherBadgeController;
use App\Http\Controllers\Web\WebPagesController;
use App\Http\Middleware\ChangeLang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:admin_api');


Route::group(['prefix' => 'web', 'middleware' => [ChangeLang::class]], function () {
    Route::get('terms',[WebPagesController::class,'terms']);
    Route::get('privacy',[WebPagesController::class,'privacy']);
});

Route::group(['prefix' => 'dashboard', 'middleware' => [ChangeLang::class]], function () {

    // start Dashboard auth
    Route::group(['prefix' => 'auth'], function () {

        Route::post('login',[AuthDashboardController::class, 'login']);

        Route::post('checkToken', [AuthDashboardController::class,'authorizeUser']);

    });

    Route::get('get-language', [SettingController::class,'getLanguage']);

    Route::group(['middleware' => 'auth:admin_api'], function () {

        Route::apiResource('banners', BannerController::class);

        // country
        Route::get('countries/dropdown',[CountryController::class,'dropdown']);
        Route::apiResource('countries', CountryController::class);

        Route::get('cities-by-country/{id}',[CityController::class,'getCitiesByCountryId']);
        Route::apiResource('cities', CityController::class);

        Route::get('nationalities-dropdown',[NationalityController::class,'dropdown']);
        Route::apiResource('nationality', NationalityController::class);

        Route::get('memorization-amounts-dropdown',[MemorizationAmountController::class,'dropdown']);
        Route::apiResource('memorization-amounts', MemorizationAmountController::class);

        Route::get('memorization-types-dropdown',[MemorizationTypeController::class,'dropdown']);
        Route::apiResource('memorization-types', MemorizationTypeController::class);

        Route::apiResource('settings', SettingController::class);

        Route::get('levels/dropdown',[LevelController::class,'dropdown']);
        Route::apiResource('levels', LevelController::class);

        Route::apiResource('digital-badges', DigitalBadgeController::class);

        Route::apiResource('teacher-badges', TeacherBadgeController::class);

        Route::apiResource('student', StudentController::class);

        Route::get('circle-types-dropdown',[CircleTypeController::class,'dropdown']);
        Route::apiResource('circle-types', CircleTypeController::class);

        Route::apiResource('circles', CircleController::class);

        Route::post('logout', [AuthDashboardController::class,'logout']);

        Route::resource('roles', RoleController::class);

        Route::resource('admins', AdminController::class);
        Route::get('all_roles', [AdminController::class,'all_roles']);

        // backup
        Route::apiResource('backup', BackupController::class);

        //statistics
        Route::get('statistics',[DashboardStatisticsController::class,'index']);
        Route::get('get-total-revenue-per-months',[DashboardStatisticsController::class,'getTotalRevenuePerMonths']);
        Route::get('get-total-revenue-for-each-year-per-months',[DashboardStatisticsController::class,'getTotalRevenueForEachYearPerMonths']);

        // JoinUs
        Route::apiResource('join-us', JoinUsController::class);

        // Language resource
        Route::resource('language', LanguageController::class);

        Route::controller(NotificationController::class)->group(function () {
            Route::get('getAllNot', 'getAllNot');
            Route::get('getNotNotRead', 'getNotNotRead');
            Route::post('clearItem/{id}', 'clearItem');
            Route::post('getNotNotRead', 'clearAll');
        });

        Route::put('update-admin-profile', [ProfileController::class,'updateAdminProfile']);

        Route::post('send-notification', [SendNotificationController::class, 'sendNotification']);

    });

});

