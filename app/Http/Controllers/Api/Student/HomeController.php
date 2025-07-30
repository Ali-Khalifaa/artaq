<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class HomeController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth:student_api'),
        ];
    }



}
