<?php

declare(strict_types=1);

namespace Brecht\LaravelAmqpInterop\Testing\Fakes;

use Interop\Amqp\AmqpConnectionFactory;

class FakeAmqpConnectionFactory implements AmqpConnectionFactory
{
    public function createContext(): FakeAmqpContext
    {
        return new FakeAmqpContext();
    }
}
