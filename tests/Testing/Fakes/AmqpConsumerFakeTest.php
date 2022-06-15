<?php

namespace Brecht\LaravelAmqpInterop\Tests\Testing\Fakes;

use Brecht\LaravelAmqpInterop\Testing\Fakes\AmqpConsumerFake;
use Brecht\LaravelAmqpInterop\Tests\TestCase;
use Interop\Amqp\Impl\AmqpQueue;

class AmqpConsumerFakeTest extends TestCase
{
    /** @test */
    public function test_consumer_tag()
    {
        $consumer = new AmqpConsumerFake(new AmqpQueue('test'));

        $consumer->setConsumerTag('test');

        $this->assertEquals('test', $consumer->getConsumerTag());
    }
}