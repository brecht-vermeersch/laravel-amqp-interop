<?php

namespace Brecht\LaravelQueueInterop;

use Enqueue\Null\NullContext;
use Interop\Queue\Context;

class ContextManagerFake extends ContextManager
{
    public function context(?string $name = null): Context
    {
        return new NullContext();
    }
}