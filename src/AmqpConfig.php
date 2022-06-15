<?php

declare(strict_types=1);

namespace Brecht\LaravelAmqpInterop;

use Illuminate\Contracts\Config\Repository;
use Interop\Amqp\AmqpConnectionFactory;

class AmqpConfig
{
    public static string $name = 'amqp';

    private Repository $config;

    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    public function getDefaultContextName(): string
    {
        return $this->config->get($this->prefixKey('default'));
    }

    /**
     * @return class-string<AmqpConnectionFactory>
     */
    public function getConnectionFactoryClass(): string
    {
        return $this->config->get($this->prefixKey('connection_factory_class'));
    }

    /**
     * @param string $name
     * @return array|string
     */
    public function getContextOptions(string $name)
    {
        $key = $this->prefixKey("contexts.$name");
        $options = $this->config->get($key);

        return $options['dsn'] ?? $options;
    }

    private function prefixKey(string $key)
    {
        return static::$name.'.'.$key;
    }
}
