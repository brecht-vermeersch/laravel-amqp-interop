<?php

namespace Brecht\LaravelAmqpInterop\Tests;

use Brecht\LaravelAmqpInterop\AmqpManager;
use Brecht\LaravelAmqpInterop\Facades\Amqp;
use Brecht\LaravelAmqpInterop\Testing\Fakes\FakeAmqpManager;

class AmqpInteropFacadeTest extends TestCase
{
    /** @test */
    public function get_facade_root_returns_context_manager()
    {
        $this->assertEquals($this->app->make(AmqpManager::class), Amqp::getFacadeRoot());
        $this->assertEquals($this->app->make('amqp'), Amqp::getFacadeRoot());
    }

    /** @test */
    public function fake_swaps_facade_root_to_null_context()
    {
        $this->assertNotInstanceOf(FakeAmqpManager::class, Amqp::getFacadeRoot());

        Amqp::fake();

        $this->assertInstanceOf(FakeAmqpManager::class, Amqp::getFacadeRoot());
    }
}
