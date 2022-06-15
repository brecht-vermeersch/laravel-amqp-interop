<?php

declare(strict_types=1);

namespace Brecht\LaravelAmqpInterop;

use Brecht\LaravelAmqpInterop\Contracts\AmqpContextFactory as FactoryContract;
use Illuminate\Contracts\Foundation\Application;
use Interop\Amqp\AmqpContext;

/**
 * @mixin AmqpContext
 */
class AmqpManager implements FactoryContract
{
    protected Application $app;

    protected AmqpConfig $config;

    /** @var AmqpContext[] */
    protected array $contexts = [];

    public function __construct(Application $app, AmqpConfig $config)
    {
        $this->app = $app;
        $this->config = $config;
    }

    public function __call($name, $arguments)
    {
        return $this->context()->{$name}(...$arguments);
    }

    public function context(?string $name = null): AmqpContext
    {
        $name = $name ?: $this->config->getDefaultContextName();

        if (! isset($this->contexts[$name])) {
            $this->contexts[$name] = $this->resolve($name);
        }

        return $this->contexts[$name];
    }

    protected function resolve(string $name): AmqpContext
    {
        $factoryClass = $this->config->getConnectionFactoryClass();
        $contextOptions = $this->config->getContextOptions($name);
        $factory = new $factoryClass($contextOptions);

        return $factory->createContext();
    }
}
