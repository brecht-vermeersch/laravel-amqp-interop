<?php

declare(strict_types=1);

namespace Brecht\LaravelAmqpInterop\Testing\Fakes;

use Interop\Amqp\AmqpConnectionFactory;

class AmqpConnectionFactoryFake implements AmqpConnectionFactory
{
    public function createContext(): AmqpContextFake
    {
        return new AmqpContextFake();
    }
}
