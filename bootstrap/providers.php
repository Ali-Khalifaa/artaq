<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\SmsServiceProvider::class,
    \SocialiteProviders\Manager\ServiceProvider::class, // add
    Maatwebsite\Excel\ExcelServiceProvider::class,
    Mccarlosen\LaravelMpdf\LaravelMpdfServiceProvider::class
];
