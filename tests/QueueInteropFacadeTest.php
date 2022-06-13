<?php

namespace Brecht\LaravelQueueInterop\Tests;

use Brecht\LaravelQueueInterop\ContextFactory;
use Brecht\LaravelQueueInterop\ContextFactoryFake;
use Brecht\LaravelQueueInterop\Facades\QueueInterop;

class QueueInteropFacadeTest extends TestCase
{
    /** @test */
    public function get_facade_root_returns_context_manager()
    {
        $this->assertEquals($this->app->make(ContextFactory::class), QueueInterop::getFacadeRoot());
    }

    /** @test */
    public function fake_swaps_facade_root_to_fake()
    {
        $this->assertNotInstanceOf(ContextFactoryFake::class, QueueInterop::getFacadeRoot());

        QueueInterop::fake();

        $this->assertInstanceOf(ContextFactoryFake::class, QueueInterop::getFacadeRoot());
    }
}
