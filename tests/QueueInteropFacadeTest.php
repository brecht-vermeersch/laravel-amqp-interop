<?php

namespace Brecht\LaravelQueueInterop\Tests;

use Brecht\LaravelQueueInterop\ContextManager;
use Brecht\LaravelQueueInterop\ContextManagerFake;
use Brecht\LaravelQueueInterop\Facades\QueueInterop;

class QueueInteropFacadeTest extends TestCase
{
    /** @test */
    public function get_facade_root_returns_context_manager()
    {
        $this->assertEquals($this->app->make(ContextManager::class), QueueInterop::getFacadeRoot());
    }

    /** @test */
    public function fake_swaps_facade_root_to_fake()
    {
        $this->assertNotInstanceOf(ContextManagerFake::class, QueueInterop::getFacadeRoot());

        QueueInterop::fake();

        $this->assertInstanceOf(ContextManagerFake::class, QueueInterop::getFacadeRoot());
    }
}