<?php

namespace Brecht\LaravelQueueInterop;

use Illuminate\Contracts\Foundation\Application;
use Interop\Queue\Context;

class ContextFactory
{
    protected Application $app;

    protected ConfigParser $config;

    /** @var Context[] */
    protected array $contexts = [];

    public function __construct(Application $app, ConfigParser $config)
    {
        $this->app = $app;
        $this->config = $config;
    }

    public function context(?string $name = null): Context
    {
        $name = $name ?: $this->config->getDefaultContextName();

        if (! isset($this->contexts[$name])) {
            $this->contexts[$name] = $this->resolve($name);
        }

        return $this->contexts[$name];
    }

    protected function resolve(string $name): Context
    {
        $factoryClass = $this->config->getContextConnectionFactoryClass($name);
        $factoryConfig = $this->config->getContextConnectionFactoryConfig($name);
        $factory = new $factoryClass($factoryConfig);

        return $factory->createContext();
    }

    public function __call($name, $arguments)
    {
        return $this->context()->{$name}(...$arguments);
    }
}
