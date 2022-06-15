<?php

declare(strict_types=1);

namespace Brecht\LaravelAmqpInterop;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Arr;
use Interop\Amqp\AmqpConnectionFactory;

class AmqpConfig
{
    public static string $name = 'queueInterop';

    private Repository $config;

    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    public function getDefaultContextName(): string
    {
        return $this->config->get(static::$name.'.default');
    }

    public function getContext(string $name): array
    {
        return $this->config->get(static::$name.'.contexts.'.$name);
    }

    /**
     * @param string $name
     * @return class-string<AmqpConnectionFactory>
     */
    public function getContextConnectionFactoryClass(string $name): string
    {
        return $this->getContext($name)['connection_factory_class'];
    }

    public function getContextConnectionFactoryConfig(string $name)
    {
        $config = $this->getContext($name);

        return $config['dns'] ?? Arr::except($config, 'connection_factory_class');
    }
}
