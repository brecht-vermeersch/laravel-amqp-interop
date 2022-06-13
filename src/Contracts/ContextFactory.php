<?php

namespace Brecht\LaravelQueueInterop\Contracts;

use Interop\Queue\Context;

interface ContextFactory
{
    /**
     * Get a transport implementation by name.
     */
    public function context(?string $name = null): Context;
}
