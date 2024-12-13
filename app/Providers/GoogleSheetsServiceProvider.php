<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\GoogleSheetsSyncService;

class GoogleSheetsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    // public function register()
    // {
    //     $this->app->bind(GoogleSheetsSyncService::class, function () {


    //         dd(class_exists(\App\Services\GoogleSheetsSyncService::class));
    //         $service = new GoogleSheetsSyncService();
    //         dd($service); // Debug and ensure instantiation works
    //         return $service;
    //     });
    // }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
