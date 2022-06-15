<?php

declare(strict_types=1);

namespace Brecht\LaravelAmqpInterop\Testing\Fakes;

use Brecht\LaravelAmqpInterop\Contracts\AmqpContextFactory;
use Interop\Amqp\AmqpContext;

/**
 * @mixin AmqpContext
 */
class AmqpManagerFake implements AmqpContextFactory
{
    public function context(?string $name = null): AmqpContextFake
    {
        return new AmqpContextFake();
    }

    public function __call($name, $arguments)
    {
        return $this->context()->{$name}(...$arguments);
    }
}
