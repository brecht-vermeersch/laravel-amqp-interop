<?php

namespace Brecht\LaravelAmqpInterop\Tests;

use Brecht\LaravelAmqpInterop\AmqpConfig;

class AmqpConfigTest extends TestCase
{
    /** @test */
    public function test_get_default_context_name()
    {
        $this->app['config']->set('amqp', [
            'default' => 'test',
        ]);

        /** @var AmqpConfig $config */
        $config = $this->app->make(AmqpConfig::class);

        $this->assertEquals('test', $config->getDefaultContextName());
    }

    /** @test */
    public function test_get_connection_factory_class()
    {
        $this->app['config']->set('amqp', [
            'connection_factory_class' => 'factory',
        ]);

        /** @var AmqpConfig $config */
        $config = $this->app->make(AmqpConfig::class);

        $this->assertEquals('factory', $config->getConnectionFactoryClass());
    }

    /** @test */
    public function test_get_context_options_as_array()
    {
        $this->app['config']->set('amqp', [
            'contexts' => [
                'test' => [
                    'host' => 'localhost',
                    'port' => 1000,
                ],
            ],
        ]);

        /** @var AmqpConfig $config */
        $config = $this->app->make(AmqpConfig::class);

        $this->assertEquals(
            [
                'host' => 'localhost',
                'port' => 1000,
            ],
            $config->getContextOptions('test')
        );
    }

    /** @test */
    public function test_get_context_options_as_dsn()
    {
        $this->app['config']->set('amqp', [
            'contexts' => [
                'test' => [
                    'dsn' => 'amqp:',
                ],
            ],
        ]);

        /** @var AmqpConfig $config */
        $config = $this->app->make(AmqpConfig::class);

        $this->assertEquals('amqp:', $config->getContextOptions('test'));
    }
}
