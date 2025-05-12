<?php

use Illuminate\Support\Facades\Route;

// Dashboard admin

Route::domain(env('DOMAIN'))->group(function () {

    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('{any}', function ($any) {
        return view('welcome');
    })->where('any', '^(?!api\/).*$');

});

