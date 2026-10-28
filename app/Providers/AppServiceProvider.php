<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Load custom global helper functions
        $helpersPath = app_path('Helpers/helpers.php');
        if (file_exists($helpersPath)) {
            require_once $helpersPath;
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Safely share global settings with all views if DB is available
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
                \Illuminate\Support\Facades\View::share('siteSettings', \App\Models\Setting::getAll());
            }
        } catch (\Throwable $e) {
            // Avoid failing during migrations or early bootstrap
        }
    }
}

