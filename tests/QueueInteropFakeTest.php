<?php

namespace Brecht\LaravelQueueInterop\Tests;

use Brecht\LaravelQueueInterop\ContextFactoryFake;
use Enqueue\Null\NullContext;

class QueueInteropFakeTest extends TestCase
{
    /** @test */
    public function context_always_returns_null_context()
    {
        $fake = $this->app->make(ContextFactoryFake::class);

        $this->assertInstanceOf(NullContext::class, $fake->context());
        $this->assertInstanceOf(NullContext::class, $fake->context('driver1'));
        $this->assertInstanceOf(NullContext::class, $fake->context('driver2'));
    }
}
