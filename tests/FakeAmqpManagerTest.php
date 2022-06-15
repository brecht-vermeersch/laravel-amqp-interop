<?php

namespace Brecht\LaravelAmqpInterop\Tests;

use Brecht\LaravelAmqpInterop\Testing\ContextFactoryFake;
use Brecht\LaravelAmqpInterop\Testing\Fakes\FakeAmqpContext;
use Brecht\LaravelAmqpInterop\Testing\Fakes\FakeAmqpManager;
use Enqueue\Null\NullContext;

class FakeAmqpManagerTest extends TestCase
{
    /** @test */
    public function context_always_returns_null_context()
    {
        $fake = $this->app->make(FakeAmqpManager::class);

        $this->assertInstanceOf(FakeAmqpContext::class, $fake->context());
        $this->assertInstanceOf(FakeAmqpContext::class, $fake->context('driver1'));
        $this->assertInstanceOf(FakeAmqpContext::class, $fake->context('driver2'));
    }
}
