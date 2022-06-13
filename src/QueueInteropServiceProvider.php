<?php

namespace Brecht\LaravelQueueInterop;

use Illuminate\Support\ServiceProvider;

class QueueInteropServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $configName = ConfigParser::$name;
        $configFile = __DIR__.'/../config/'.$configName.'.php';

        $this->publishes([ $configFile => config_path($configName . '.php')]);
        $this->mergeConfigFrom($configFile, $configName);
    }

    public function register(): void
    {
        $this->app->bind(ConfigParser::class);
        $this->app->singleton(ContextFactory::class);
        $this->app->singleton(ContextFactoryFake::class);
    }
}
