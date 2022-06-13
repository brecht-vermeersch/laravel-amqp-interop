<?php

namespace Brecht\LaravelQueueInterop\Tests;

use Brecht\LaravelQueueInterop\ConfigParser;
use Brecht\LaravelQueueInterop\Contracts\ConfigParser as ConfigParserContract;

class ConfigParserTest extends TestCase
{
    /** @test */
    public function it_binds_to_container()
    {
        $this->assertInstanceOf(ConfigParser::class, $this->app->make(ConfigParserContract::class), );
    }

    /** @test */
    public function test_get_default_context_name()
    {
        $this->app['config']->set('queueInterop', [
            'default' => 'test',
        ]);

        /** @var ConfigParser $config */
        $config = $this->app->make(ConfigParser::class);

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

        /** @var ConfigParser $config */
        $config = $this->app->make(ConfigParser::class);

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

        /** @var ConfigParser $config */
        $config = $this->app->make(ConfigParser::class);

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

        /** @var ConfigParser $config */
        $config = $this->app->make(ConfigParser::class);

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

        /** @var ConfigParser $config */
        $config = $this->app->make(ConfigParser::class);

        $this->assertEquals('amqp:', $config->getContextConnectionFactoryConfig('test'));
    }
}
