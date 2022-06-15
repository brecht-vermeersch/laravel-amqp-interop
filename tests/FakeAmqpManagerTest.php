<?php

namespace Brecht\LaravelAmqpInterop\Tests;

use Brecht\LaravelAmqpInterop\Testing\ContextFactoryFake;
use Brecht\LaravelAmqpInterop\Testing\Fakes\AmqpContextFake;
use Brecht\LaravelAmqpInterop\Testing\Fakes\AmqpManagerFake;
use Enqueue\Null\NullContext;

class FakeAmqpManagerTest extends TestCase
{
    /** @test */
    public function context_always_returns_null_context()
    {
        $fake = $this->app->make(AmqpManagerFake::class);

        $this->assertInstanceOf(AmqpContextFake::class, $fake->context());
        $this->assertInstanceOf(AmqpContextFake::class, $fake->context('driver1'));
        $this->assertInstanceOf(AmqpContextFake::class, $fake->context('driver2'));
    }
}
