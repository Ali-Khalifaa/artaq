<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\LanguageInterface;
use App\Repositories\LanguageRepository;
use App\Interfaces\PageInterface;
use App\Repositories\PageRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->bind(LanguageInterface::class, LanguageRepository::class);
        $this->app->bind(PageInterface::class, PageRepository::class);
    }

    /**
     * Get the services provided by the provider.
    */
    public function provides(): array
    {
        return [];
    }
}
