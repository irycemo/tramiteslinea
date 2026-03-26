<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

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

        if (app()->isProduction()) {

            DB::prohibitDestructiveCommands();

        }

        Model::shouldBeStrict();

        if(app()->isProduction()){

            URL::forceScheme('https');

            Livewire::setScriptRoute(function ($handle) {
                return Route::get('/tramiteslinea/public/vendor/livewire/livewire.js', $handle);
            });

            Livewire::setUpdateRoute(function ($handle) {
                return Route::post('/tramiteslinea/livewire/update', $handle);
            });

        }

        if(app()->environment('staging')){

            Livewire::setScriptRoute(function ($handle) {
                return Route::get('/tramiteslinea/public/vendor/livewire/livewire.js', $handle);
            });

            Livewire::setUpdateRoute(function ($handle) {
                return Route::post('/tramiteslinea/livewire/update', $handle);
            });

        }

    }
}
