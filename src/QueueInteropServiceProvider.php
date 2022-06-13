<?php

namespace Brecht\LaravelQueueInterop;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class QueueInteropServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $configFile = __DIR__.'/../config/queueInterop.php';

        $this->publishes([
            $configFile => config_path('queueInterop.php'),
        ]);

        $this->mergeConfigFrom($configFile, 'queueInterop');
    }

    public function register(): void
    {
        $this->app->singleton(ContextManager::class, fn (Application $app) => new ContextManager($app));
    }
}
