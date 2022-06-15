<?php

declare(strict_types=1);

namespace Brecht\LaravelAmqpInterop\Testing\Fakes;

use Interop\Amqp\AmqpConnectionFactory;
use Interop\Queue\Context;

class FakeAmqpConnectionFactory implements AmqpConnectionFactory
{
    public function createContext(): Context
    {
        return new FakeAmqpContext();
    }
}
