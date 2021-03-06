<?php

namespace Brecht\LaravelAmqpInterop\Tests;

use Brecht\LaravelAmqpInterop\AmqpManager;
use Brecht\LaravelAmqpInterop\Testing\Fakes\AmqpConnectionFactoryFake;
use Brecht\LaravelAmqpInterop\Testing\Fakes\AmqpContextFake;
use Interop\Amqp\AmqpContext;
use Interop\Amqp\Impl\AmqpQueue;
use Interop\Queue\Context;
use Mockery\MockInterface;

class AmqpManagerTest extends TestCase
{
    /** @test */
    public function it_binds_to_container_as_singleton()
    {
        $manager1 = $this->app->make('amqp');
        $manager2 = $this->app->make('amqp');

        $this->assertInstanceOf(AmqpManager::class, $manager1);
        $this->assertInstanceOf(AmqpManager::class, $manager2);
        $this->assertEquals($manager1, $manager2);
    }

    /** @test */
    public function default_context_can_be_resolved()
    {
        $this->app['config']->set('amqp', [
            'connection_factory_class' => AmqpConnectionFactoryFake::class,
            'default' => 'null',
            'contexts' => [
                'null' => [
                ],
            ],
        ]);

        $manager = $this->app->make(AmqpManager::class);

        $this->assertInstanceOf(AmqpContextFake::class, $manager->context());
    }

    /** @test */
    public function other_context_can_be_resolved()
    {
        $this->app['config']->set('amqp', [
            'connection_factory_class' => AmqpConnectionFactoryFake::class,
            'contexts' => [
                'other' => [
                ],
            ],
        ]);

        $manager = $this->app->make(AmqpManager::class);

        $this->assertInstanceOf(AmqpContextFake::class, $manager->context('other'));
    }

    /** @test */
    public function it_forwards_method_calls_to_default_context()
    {
        $this->app['config']->set('amqp', [
            'default' => 'null',
            'contexts' => [
                'null' => [
                    'connection_factory_class' => AmqpConnectionFactoryFake::class,
                ],
            ],
        ]);

        $nullQueue = new AmqpQueue('nullQueue');

        /** @var Context $contextMock */
        $contextMock = $this->mock(AmqpContext::class, function (MockInterface $mock) use ($nullQueue) {
            $mock->shouldReceive('createMessage')->with('testBody', ['testProp'], ['testHeader']);
            $mock->shouldReceive('createTopic')->with('testTopic');
            $mock->shouldReceive('createQueue')->with('testQueue');
            $mock->shouldReceive('createTemporaryQueue');
            $mock->shouldReceive('createProducer');
            $mock->shouldReceive('createConsumer')->with($nullQueue);
            $mock->shouldReceive('createSubscriptionConsumer');
            $mock->shouldReceive('purgeQueue')->with($nullQueue);
            $mock->shouldReceive('close');
        });

        /** @var AmqpManager $managerMock */
        $managerMock = $this->partialMock(AmqpManager::class, function (MockInterface $mock) use ($contextMock) {
            $mock->shouldReceive('context')->andReturn($contextMock);
        });

        $managerMock->createMessage('testBody', ['testProp'], ['testHeader']);
        $managerMock->createTopic('testTopic');
        $managerMock->createQueue('testQueue');
        $managerMock->createTemporaryQueue();
        $managerMock->createProducer();
        $managerMock->createConsumer($nullQueue);
        $managerMock->createSubscriptionConsumer();
        $managerMock->purgeQueue($nullQueue);
        $managerMock->close();
    }
}
