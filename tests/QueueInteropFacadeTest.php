<?php

namespace Brecht\LaravelAmqpInterop\Tests;

use Brecht\LaravelAmqpInterop\AmqpManager;
use Brecht\LaravelAmqpInterop\Facades\QueueInterop;
use Brecht\LaravelAmqpInterop\Testing\ContextFactoryFake;
use Enqueue\Null\NullContext;

class QueueInteropFacadeTest extends TestCase
{
    /** @test */
    public function get_facade_root_returns_context_manager()
    {
        $this->assertEquals($this->app->make(AmqpManager::class), QueueInterop::getFacadeRoot());
    }

    /** @test */
    public function fake_swaps_facade_root_to_null_context()
    {
        $this->assertNotInstanceOf(NullContext::class, QueueInterop::getFacadeRoot());

        QueueInterop::fake();

        $this->assertInstanceOf(NullContext::class, QueueInterop::getFacadeRoot());
    }
}
