<?php

namespace Brecht\LaravelQueueInterop;

use Brecht\LaravelQueueInterop\Contracts\ConfigParser;
use Brecht\LaravelQueueInterop\Contracts\ContextFactory;
use Illuminate\Contracts\Foundation\Application;
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

    protected ConfigParser $config;

    /** @var Context[] */
    protected array $contexts = [];

    public function __construct(Application $app)
    {
        $this->app = $app;
        /** @phpstan-ignore-next-line */
        $this->config = $app->make(ConfigParser::class);
    }

    public function context(?string $name = null): Context
    {
        $name = $name ?: $this->config->getDefaultContextName();

        if (! isset($this->contexts[$name])) {
            $this->contexts[$name] = $this->resolve($name);
        }

        return $this->contexts[$name];
    }

    protected function resolve(string $name): Context
    {
        $factoryClass = $this->config->getContextConnectionFactoryClass($name);
        $factoryConfig = $this->config->getContextConnectionFactoryConfig($name);
        $factory = new $factoryClass($factoryConfig);

        return $factory->createContext();
    }

    /**
     * @param string $body
     * @param array<string, mixed> $properties
     * @param array<string, mixed> $headers
     * @return Message
     */
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
