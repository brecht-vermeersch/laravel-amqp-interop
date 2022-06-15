<?php

namespace Brecht\LaravelAmqpInterop\Tests;

use Brecht\LaravelAmqpInterop\AmqpInteropServiceProvider;
use Brecht\LaravelAmqpInterop\Facades\Amqp;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            AmqpInteropServiceProvider::class,
        ];
    }
}
