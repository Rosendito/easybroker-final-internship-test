<?php

namespace App\Providers;

use App\Actions\EasyBrokerActionBase;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EasyBrokerActionBase::class, function ($app) {
            return new EasyBrokerActionBase(
                $app->make(EasyBrokerService::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
