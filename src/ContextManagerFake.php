<?php

namespace Brecht\LaravelQueueInterop;

use Brecht\LaravelQueueInterop\Contracts\ContextManager as ContextManagerContract;
use Enqueue\Null\NullContext;
use Interop\Queue\Context;

class ContextManagerFake extends NullContext implements ContextManagerContract
{
    public function context(?string $name = null): Context
    {
        return $this;
    }
}
