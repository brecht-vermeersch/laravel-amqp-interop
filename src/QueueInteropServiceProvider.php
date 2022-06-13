<?php

namespace Brecht\LaravelQueueInterop;

use Brecht\LaravelQueueInterop\Contracts\ConfigParser as ConfigParserContract;
use Brecht\LaravelQueueInterop\Contracts\ContextManager as ContextManagerContract;
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
        $this->app->bind(ConfigParserContract::class, ConfigParser::class);
        $this->app->singleton(ContextManagerContract::class, ContextManager::class);
    }
}
