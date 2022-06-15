<?php

namespace Brecht\LaravelAmqpInterop\Tests\Testing\Fakes;

use Brecht\LaravelAmqpInterop\Testing\Fakes\AmqpConnectionFactoryFake;
use Brecht\LaravelAmqpInterop\Testing\Fakes\AmqpContextFake;
use Brecht\LaravelAmqpInterop\Tests\TestCase;

class AmqpConnectionFactoryFakeTest extends TestCase
{
    public function context_returns_fake()
    {
        $factory = new AmqpConnectionFactoryFake();

        $this->assertInstanceOf(AmqpContextFake::class, $factory->createContext());
    }
}