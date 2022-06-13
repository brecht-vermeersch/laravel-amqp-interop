<?php

namespace Brecht\LaravelQueueInterop\Contracts;

use Interop\Queue\ConnectionFactory;

interface ConfigParser
{
    public function getDefaultContextName(): string;

    /**
     * @param string $name
     * @return array<string, mixed>
     */
    public function getContext(string $name): array;

    /**
     * @param string $name
     * @return class-string<ConnectionFactory>
     */
    public function getContextConnectionFactoryClass(string $name): string;

    /**
     * @param string $name
     * @return array<string, mixed>|string
     */
    public function getContextConnectionFactoryConfig(string $name);
}
