<?php

namespace Brecht\LaravelQueueInterop;

use Brecht\LaravelQueueInterop\Contracts\ContextFactory;
use Illuminate\Contracts\Foundation\Application;
use Interop\Queue\ConnectionFactory;
use Interop\Queue\Consumer;
use Interop\Queue\Context;
use Interop\Queue\Destination;
use Interop\Queue\Message;
use Interop\Queue\Producer;
use Interop\Queue\Queue;
use Interop\Queue\SubscriptionConsumer;
use Interop\Queue\Topic;

class ContextManager implements ContextFactory, Context
{
    protected Application $app;

    /** @var Context[] */
    protected array $contexts = [];

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function context(?string $name = null): Context
    {
        $name = $name ?: $this->getDefaultContextName();

        if (! isset($this->contexts[$name])) {
            $this->contexts[$name] = $this->resolve($name);
        }

        return $this->contexts[$name];
    }

    protected function resolve(string $name): Context
    {
        $config = $this->getConfig($name);

        $connectionFactoryClass = $this->getConfigConnectionFactoryClass($config);
        $connectionFactory = new $connectionFactoryClass($config['dns'] ?? $config);

        return $connectionFactory->createContext();
    }

    protected function getConfig(string $name): array
    {
        return $this->app['config']["queueInterop.contexts.$name"];
    }

    protected function getConfigConnectionFactoryClass(array $config): string
    {
        if (empty($config['connection_factory_class'])) {
            throw new \LogicException('The "connection_factory_class" option is required');
        }

        $factoryClass = $config['connection_factory_class'];
        if (! class_exists($factoryClass)) {
            throw new \LogicException(sprintf('The "connection_factory_class" option "%s" is not a class', $factoryClass));
        }

        $rc = new \ReflectionClass($factoryClass);
        if (! $rc->implementsInterface(ConnectionFactory::class)) {
            throw new \LogicException(sprintf('The "connection_factory_class" option must contain a class that implements "%s" but it is not', ConnectionFactory::class));
        }

        return $factoryClass;
    }

    protected function getDefaultContextName(): string
    {
        return $this->app['config']['queueInterop.default'];
    }

    public function createMessage(string $body = '', array $properties = [], array $headers = []): Message
    {
        return $this->context()->createMessage($body, $properties, $headers);
    }

    public function createTopic(string $topicName): Topic
    {
        return $this->context()->createTopic($topicName);
    }

    public function createQueue(string $queueName): Queue
    {
        return $this->context()->createQueue($queueName);
    }

    public function createTemporaryQueue(): Queue
    {
        return $this->context()->createTemporaryQueue();
    }

    public function createProducer(): Producer
    {
        return $this->context()->createProducer();
    }

    public function createConsumer(Destination $destination): Consumer
    {
        return $this->context()->createConsumer($destination);
    }

    public function createSubscriptionConsumer(): SubscriptionConsumer
    {
        return $this->context()->createSubscriptionConsumer();
    }

    public function purgeQueue(Queue $queue): void
    {
        $this->context()->purgeQueue($queue);
    }

    public function close(): void
    {
        $this->context()->close();
    }
}
