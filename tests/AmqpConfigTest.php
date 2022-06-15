<?php

namespace Brecht\LaravelAmqpInterop\Tests;

use Brecht\LaravelAmqpInterop\AmqpConfig;

class AmqpConfigTest extends TestCase
{
    /** @test */
    public function test_get_default_context_name()
    {
        $this->app['config']->set('queueInterop', [
            'default' => 'test',
        ]);

        /** @var AmqpConfig $config */
        $config = $this->app->make(AmqpConfig::class);

        $this->assertEquals('test', $config->getDefaultContextName());
    }

    /** @test */
    public function test_get_context()
    {
        $this->app['config']->set('queueInterop', [
            'contexts' => [
                'test' => [
                    'connection_factory_class' => 'factory',
                ],
            ],
        ]);

        /** @var AmqpConfig $config */
        $config = $this->app->make(AmqpConfig::class);

        $this->assertEquals(
            [
                'connection_factory_class' => 'factory',
            ],
            $config->getContext('test')
        );
    }

    /** @test */
    public function test_get_context_connection_factory_class()
    {
        $this->app['config']->set('queueInterop', [
            'default' => 'test',
            'contexts' => [
                'test' => [
                    'connection_factory_class' => 'factory',
                ],
            ],
        ]);

        /** @var AmqpConfig $config */
        $config = $this->app->make(AmqpConfig::class);

        $this->assertEquals('factory', $config->getContextConnectionFactoryClass('test')
        );
    }

    /** @test */
    public function test_get_context_connection_factory_config_as_array()
    {
        $this->app['config']->set('queueInterop', [
            'default' => 'test',
            'contexts' => [
                'test' => [
                    'connection_factory_class' => 'factory',
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
            $config->getContextConnectionFactoryConfig('test')
        );
    }

    /** @test */
    public function test_get_context_connection_factory_config_as_dsn()
    {
        $this->app['config']->set('queueInterop', [
            'default' => 'test',
            'contexts' => [
                'test' => [
                    'dns' => 'amqp:',
                ],
            ],
        ]);

        /** @var AmqpConfig $config */
        $config = $this->app->make(AmqpConfig::class);

        $this->assertEquals('amqp:', $config->getContextConnectionFactoryConfig('test'));
    }
}
