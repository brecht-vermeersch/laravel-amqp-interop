<?php

namespace Brecht\LaravelQueueInterop\Facades;

use Brecht\LaravelQueueInterop\ContextManager;
use Brecht\LaravelQueueInterop\ContextManagerFake;
use Illuminate\Support\Facades\Facade;
use Interop\Queue\Consumer;
use Interop\Queue\Context;
use Interop\Queue\Destination;
use Interop\Queue\Message;
use Interop\Queue\Producer;
use Interop\Queue\Queue;
use Interop\Queue\SubscriptionConsumer;
use Interop\Queue\Topic;

/**
 * @method static Context context(?string $name = null)
 * @method static Message createMessage(string $body = '', array $properties = [], array $headers = [])
 * @method static Topic createTopic(string $topicName)
 * @method static Queue createQueue(string $queueName)
 * @method static Queue createTemporaryQueue()
 * @method static Producer createProducer()
 * @method static Consumer createConsumer(Destination $destination)
 * @method static SubscriptionConsumer createSubscriptionConsumer()
 * @method static void purgeQueue(Queue $queue)
 * @method static void close()
 *
 * @see ContextManager, ContextManagerFake
 */
class QueueInterop extends Facade
{
    public static function fake(): ContextManagerFake
    {
        static::swap($fake = new ContextManagerFake());

        return $fake;
    }

    public static function getFacadeAccessor(): string
    {
        return ContextManager::class;
    }
}
