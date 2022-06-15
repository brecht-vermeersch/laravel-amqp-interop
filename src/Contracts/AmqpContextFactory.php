<?php

namespace Brecht\LaravelAmqpInterop\Contracts;

use Interop\Amqp\AmqpContext;

interface AmqpContextFactory
{
    public function context(?string $name = null): AmqpContext;
}
