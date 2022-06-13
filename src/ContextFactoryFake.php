<?php

namespace Brecht\LaravelQueueInterop;

use Enqueue\Null\NullContext;
use Interop\Queue\Context;

class ContextFactoryFake extends ContextFactory
{
    public function context(?string $name = null): Context
    {
        return new NullContext();
    }
}
