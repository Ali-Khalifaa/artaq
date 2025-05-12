<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(RepositoryServiceProvider::class);
        $this->app->register(SmsServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        Gate::define('read-channel-messages', function ($user,$channel) {
            return $user->id === $channel->user1_id && $channel->user1_type === get_class($user) || ($user->id === $channel->user2_id && $channel->user2_type === get_class($user));
        });

        Event::listen(function (\SocialiteProviders\Manager\SocialiteWasCalled $event) {
            $event->extendSocialite('apple', \SocialiteProviders\Apple\Provider::class);
        });


        RateLimiter::for('storeBooking', function (Request $request) {
            return Limit::perMinute(1)->by($request->ip());
        });
         RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(3)->by($request->ip());
        });
        RateLimiter::for('sms', function (Request $request) {
            return Limit::perMinute(1)->by($request->ip());
        });
    }
}
