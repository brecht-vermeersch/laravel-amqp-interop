<?php

declare(strict_types=1);

namespace Brecht\LaravelAmqpInterop;

use Brecht\LaravelAmqpInterop\Contracts\AmqpContextFactory as FactoryContract;
use Illuminate\Support\ServiceProvider;

class AmqpInteropServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $configName = AmqpConfig::$name;
        $configFile = __DIR__.'/../config/'.$configName.'.php';

        $this->publishes([$configFile => config_path($configName.'.php')]);
        $this->mergeConfigFrom($configFile, $configName);
    }

    public function register(): void
    {
        $this->app->singleton('amqp', AmqpManager::class);
    }
}
