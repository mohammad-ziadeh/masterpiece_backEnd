<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;  // Ensure this is imported

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Share breadcrumbs across all views
        // view()->share('breadcrumbs', [
        //     ['url' => route('dashboard'), 'label' => 'Dashboard'],
        //     ['url' => route('profile.edit'), 'label' => 'Profile'],
        // ]);
    }
}
