<?php

namespace Brecht\LaravelQueueInterop;

use Brecht\LaravelQueueInterop\Contracts\ConfigParser as ConfigParserContract;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Arr;

class ConfigParser implements ConfigParserContract
{
    private Repository $config;

    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    public function getDefaultContextName(): string
    {
        return $this->config->get('queueInterop.default');
    }

    public function getContext(string $name): array
    {
        return $this->config->get("queueInterop.contexts.$name");
    }

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
