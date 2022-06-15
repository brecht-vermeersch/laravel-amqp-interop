<?php

namespace Brecht\LaravelAmqpInterop\Testing\Fakes;

use Brecht\LaravelAmqpInterop\Contracts\AmqpContextFactory;
use Interop\Amqp\AmqpContext;

/**
 * @mixin AmqpContext
 */
class FakeAmqpManager implements AmqpContextFactory
{
    public function context(?string $name = null): AmqpContext
    {
        return new FakeAmqpContext();
    }

    public function __call($name, $arguments)
    {
        return $this->context()->{$name}(...$arguments);
    }
}
