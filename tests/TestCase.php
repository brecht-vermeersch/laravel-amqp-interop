<?php

namespace Brecht\LaravelQueueInterop\Tests;

use Brecht\LaravelQueueInterop\QueueInteropServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            QueueInteropServiceProvider::class,
        ];
    }
}
