<?php

namespace Brecht\LaravelAmqpInterop\Testing\Fakes;

use Interop\Amqp\AmqpBind;
use Interop\Amqp\AmqpConsumer;
use Interop\Amqp\AmqpContext;
use Interop\Amqp\AmqpMessage;
use Interop\Amqp\AmqpQueue;
use Interop\Amqp\AmqpTopic;
use Interop\Queue\Destination;
use Interop\Queue\Queue;

class FakeAmqpContext implements AmqpContext
{
    public function declareTopic(AmqpTopic $topic): void
    {
    }

    public function deleteTopic(AmqpTopic $topic): void
    {
    }

    public function declareQueue(AmqpQueue $queue): int
    {
        return 0;
    }

    public function deleteQueue(AmqpQueue $queue): void
    {
    }

    public function bind(AmqpBind $bind): void
    {
    }

    public function unbind(AmqpBind $bind): void
    {
    }

    public function setQos(int $prefetchSize, int $prefetchCount, bool $global): void
    {
    }

    public function createSubscriptionConsumer(): FakeAmqpSubscriptionConsumer
    {
        return new FakeAmqpSubscriptionConsumer();
    }

    public function purgeQueue(Queue $queue): void
    {
    }

    public function close(): void
    {
    }

    public function createQueue(string $queueName): AmqpQueue
    {
        return new \Interop\Amqp\Impl\AmqpQueue($queueName);
    }

    public function createTemporaryQueue(): AmqpQueue
    {
        return $this->createQueue(uniqid('', true));
    }

    public function createProducer(): FakeAmqpProducer
    {
        return new FakeAmqpProducer();
    }

    public function createTopic(string $topicName): AmqpTopic
    {
        return new \Interop\Amqp\Impl\AmqpTopic($topicName);
    }

    public function createMessage($body = '', array $properties = [], array $headers = []): AmqpMessage
    {
        return new \Interop\Amqp\Impl\AmqpMessage();
    }

    public function createConsumer(Destination $destination): AmqpConsumer
    {
        return new FakeAmqpConsumer($destination);
    }
}
