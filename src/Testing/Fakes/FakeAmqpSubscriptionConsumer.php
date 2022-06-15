<?php

namespace Brecht\LaravelAmqpInterop\Testing\Fakes;

use Interop\Amqp\AmqpSubscriptionConsumer;
use Interop\Queue\Consumer;

class FakeAmqpSubscriptionConsumer implements AmqpSubscriptionConsumer
{
    public function consume(int $timeout = 0): void
    {
    }

    public function subscribe(Consumer $consumer, callable $callback): void
    {
    }

    public function unsubscribe(Consumer $consumer): void
    {
    }

    public function unsubscribeAll(): void
    {
    }
}
