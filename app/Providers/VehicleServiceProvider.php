<?php

namespace App\Providers;

use App\Interfaces\VehicleRepository;
use App\Repositories\GuzzleVehicleRepository;
use Illuminate\Support\ServiceProvider;

class VehicleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(VehicleRepository::class, GuzzleVehicleRepository::class);
    }
}
