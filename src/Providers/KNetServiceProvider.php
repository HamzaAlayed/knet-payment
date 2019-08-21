<?php

namespace DeveloperH\Knet\Providers;

use DeveloperH\Knet\Services\KNet;
use Illuminate\Support\ServiceProvider;

class KNetServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('knet', function () {
            return new KNet();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
           __DIR__.'/../../config' => realpath('config'),
        ], 'knet-payment');

        if (null === $this->app['config']->get('kent.php')) {
            $this->app['config']->set('knet', require __DIR__.'/../../config/knet.php');
        }
        $this->mergeConfigFrom(__DIR__.'/../../config/knet.php', 'knet-payment');

        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
    }
}
