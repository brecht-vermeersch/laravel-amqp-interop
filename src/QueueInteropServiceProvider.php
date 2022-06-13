<?php

namespace Brecht\LaravelQueueInterop;


use Illuminate\Support\ServiceProvider;

class QueueInteropServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $configFile = __DIR__."/../config/queueInterop.php";

        $this->publishes([
            $configFile => config_path("queueInterop.php"),
        ]);

        $this->mergeConfigFrom($configFile, 'queueInterop');
    }

    public function register(): void
    {
        $this->app->bind(ConfigParser::class);
        $this->app->singleton(ContextFactory::class);
        $this->app->singleton(ContextFactoryFake::class);
    }
}
