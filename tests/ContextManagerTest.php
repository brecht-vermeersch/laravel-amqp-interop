<?php

namespace Brecht\LaravelQueueInterop\Tests;

use Brecht\LaravelQueueInterop\ContextManager;
use Enqueue\Null\NullConnectionFactory;
use Enqueue\Null\NullContext;
use Enqueue\Null\NullQueue;
use Interop\Queue\Context;
use Mockery\MockInterface;

class ContextManagerTest extends TestCase
{
    /** @test */
    public function it_binds_to_container_as_singleton()
    {
        $manager1 = $this->app->make(ContextManager::class);
        $manager2 = $this->app->make(ContextManager::class);

        $this->assertInstanceOf(ContextManager::class, $manager1);
        $this->assertInstanceOf(ContextManager::class, $manager2);
        $this->assertEquals($manager1, $manager2);
    }

    /** @test */
    public function default_context_can_be_resolved()
    {
        $this->app['config']->set('queueInterop', [
            'default' => 'null',
            'contexts' => [
                'null' => [
                    'connection_factory_class' => NullConnectionFactory::class,
                ],
            ],
        ]);

        $manager = new ContextManager($this->app);

        $this->assertInstanceOf(NullContext::class, $manager->context());
    }

    /** @test */
    public function other_context_can_be_resolved()
    {
        $this->app['config']->set('queueInterop', [
            'contexts' => [
                'other' => [
                    'connection_factory_class' => NullConnectionFactory::class,
                ],
            ],
        ]);

        $manager = new ContextManager($this->app);

        $this->assertInstanceOf(NullContext::class, $manager->context('other'));
    }

    /** @test */
    public function it_forwards_method_calls_to_default_context()
    {
        $this->app['config']->set('queueInterop', [
            'default' => 'null',
            'contexts' => [
                'null' => [
                    'connection_factory_class' => NullConnectionFactory::class,
                ],
            ],
        ]);

        $nullQueue = new NullQueue('nullQueue');

        /** @var Context $contextMock */
        $contextMock = $this->mock(Context::class, function (MockInterface $mock) use ($nullQueue) {
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

        /** @var ContextManager $managerMock */
        $managerMock = $this->partialMock(ContextManager::class, function (MockInterface $mock) use ($contextMock) {
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