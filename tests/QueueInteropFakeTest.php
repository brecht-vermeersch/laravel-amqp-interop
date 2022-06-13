<?php

namespace Brecht\LaravelQueueInterop\Tests;

use Brecht\LaravelQueueInterop\ContextManagerFake;
use Enqueue\Null\NullContext;

class QueueInteropFakeTest extends TestCase
{
    /** @test */
    public function context_always_returns_null_context()
    {
        $fake = new ContextManagerFake($this->app);

        $this->assertInstanceOf(NullContext::class, $fake->context());
        $this->assertInstanceOf(NullContext::class, $fake->context('driver1'));
        $this->assertInstanceOf(NullContext::class, $fake->context('driver2'));
    }
}
