<?php

return [
    'connection_factory_class' => \Brecht\LaravelAmqpInterop\Testing\Fakes\AmqpConnectionFactoryFake::class,

    'default' => env('ENQUEUE_DRIVER', 'example'),

    'contexts' => [
        'example' => [
            'dsn' => env('QUEUE_INTEROP_DSN', 'amqp:'),
            // instead of dsn, you can also specify config options
            // 'host' => 'localhost',
            // 'port' => 5672,
            // 'vhost' => '/',
            // 'user' => 'guest',
            // 'pass' => 'guest',
            // 'persisted' => true,
        ],
    ],
];
