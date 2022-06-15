<?php

declare(strict_types=1);

namespace Brecht\LaravelAmqpInterop\Testing\Fakes;

use Interop\Amqp\AmqpProducer;
use Interop\Queue\Destination;
use Interop\Queue\Message;
use Interop\Queue\Producer;
use Interop\Queue\Queue;
use Interop\Queue\Topic;
use PHPUnit\Framework\Assert as PHPUnit;

class FakeAmqpProducer implements AmqpProducer
{
    private ?int $deliveryDelay;

    private ?int $priority;

    private ?int $timeToLive;

    /** @var array<string, Message[]> */
    private array $queueMessages = [];

    /** @var array<string, Message[]> */
    private array $topicMessages = [];

    public function send(Destination $destination, Message $message): void
    {
        if ($destination instanceof Queue) {
            $this->sendToQueue($destination, $message);
        } elseif ($destination instanceof Topic) {
            $this->sendToTopic($destination, $message);
        }
    }

    private function sendToQueue(Queue $queue, Message $message): void
    {
        $queueName = $queue->getQueueName();

        if (array_key_exists($queueName, $this->queueMessages)) {
            $this->queueMessages[$queueName][] = $message;
        } else {
            $this->queueMessages[$queueName] = [$message];
        }
    }

    private function sendToTopic(Topic $topic, Message $message): void
    {
        $topicName = $topic->getTopicName();

        if (array_key_exists($topicName, $this->queueMessages)) {
            $this->topicMessages[$topicName][] = $message;
        } else {
            $this->topicMessages[$topicName] = [$message];
        }
    }

    public function assertSentToQueue(string $queueName, \Closure $callback = null): void
    {
        $callback = $callback ?? fn () => true;

        PHPUnit::assertTrue(
            count(array_filter($this->queueMessages[$queueName] ?? [], $callback)) > 0,
            "The expected [$queueName] queue message was not pushed."
        );
    }

    public function assertSentToQueueTimes(string $queueName, int $count): void
    {
        $times = count($this->queueMessages[$queueName] ?? []);

        PHPUnit::assertSame(
            $times, $count,
            "The expected [$queueName] queue was pushed $count times instead of $times times."
        );
    }

    public function assertSentToTopic(string $topicName, \Closure $callback = null): void
    {
        $callback = $callback ?? fn () => true;

        PHPUnit::assertTrue(
            count(array_filter($this->topicMessages[$topicName] ?? [], $callback)) > 0,
            "The expected [$topicName] topic message was not pushed."
        );
    }

    public function assertSentToTopicTimes(string $topicName, int $count): void
    {
        $times = count($this->topicMessages[$topicName] ?? []);

        PHPUnit::assertSame(
            $times, $count,
            "The expected [$topicName] topic was pushed $count times instead of $times times."
        );
    }

    public function setDeliveryDelay(int $deliveryDelay = null): Producer
    {
        $this->deliveryDelay = $deliveryDelay;

        return $this;
    }

    public function getDeliveryDelay(): ?int
    {
        return $this->deliveryDelay;
    }

    public function setPriority(int $priority = null): Producer
    {
        $this->priority = $priority;

        return $this;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setTimeToLive(int $timeToLive = null): Producer
    {
        $this->timeToLive = $timeToLive;

        return $this;
    }

    public function getTimeToLive(): ?int
    {
        return $this->timeToLive;
    }
}
