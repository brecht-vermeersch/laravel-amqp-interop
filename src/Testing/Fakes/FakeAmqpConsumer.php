<?php

declare(strict_types=1);

namespace Brecht\LaravelAmqpInterop\Testing\Fakes;

use Interop\Amqp\AmqpConsumer;
use Interop\Amqp\AmqpMessage;
use Interop\Amqp\AmqpQueue;
use Interop\Queue\Message;

class FakeAmqpConsumer implements AmqpConsumer
{
    private ?string $consumerTag;

    private int $flags;

    private AmqpQueue $queue;

    public function __construct(AmqpQueue $queue)
    {
        $this->flags = self::FLAG_NOPARAM;
        $this->queue = $queue;
    }

    public function setConsumerTag(string $consumerTag = null): void
    {
        $this->consumerTag = $consumerTag;
    }

    public function getConsumerTag(): ?string
    {
        return $this->consumerTag;
    }

    public function clearFlags(): void
    {
        $this->flags = self::FLAG_NOPARAM;
    }

    public function addFlag(int $flag): void
    {
        $this->flags |= $flag;
    }

    public function getFlags(): int
    {
        return $this->flags;
    }

    public function setFlags(int $flags): void
    {
        $this->flags = $flags;
    }

    public function receiveNoWait(): ?AmqpMessage
    {
        return null;
    }

    public function getQueue(): AmqpQueue
    {
        return $this->queue;
    }

    public function receive(int $timeout = 0): ?AmqpMessage
    {
        return null;
    }

    public function acknowledge(Message $message): void
    {
    }

    /**
     * @param AmqpMessage $message
     * @param bool $requeue
     * @return void
     */
    public function reject($message, bool $requeue = false): void
    {
    }
}
