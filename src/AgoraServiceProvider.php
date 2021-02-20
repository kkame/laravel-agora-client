<?php

namespace Kkame\Agora;

use Illuminate\Support\ServiceProvider;

class AgoraServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $configPath = __DIR__ . '/../config/agora.php';
        $this->mergeConfigFrom($configPath, 'agora');
        /*
                $this->app->singleton(
                    Searcher::class,
                    function (Application $app) {
                        return new Searcher($app[Client::class], config('agora.id'), config('agora.password'));
                    }
                );*/
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes(
            [
                __DIR__ . '/../config/agora.php' => $this->app->configPath('agora.php'),
            ],
            'config'
        );
    }
}
