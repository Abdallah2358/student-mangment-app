<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

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
    public function boot(): void
    {
        // Disable mass assignment protection for all models
        // This is not recommended for production code, but can be useful for testing or rapid development.
        // Filament only saves valid data to models so the models can be unguarded safely.
        Model::unguard();

        //
    }
}
