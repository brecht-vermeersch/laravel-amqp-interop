<?php

return [
    'default' => env('ENQUEUE_DRIVER', 'null'),

    'contexts' => [
        'example' => [
            'connection_factory_class' => \Brecht\LaravelAmqpInterop\Testing\Fakes\AmqpConnectionFactoryFake::class,
            'dsn' => env('QUEUE_INTEROP_DSN', 'amqp:'),
            // instead of dsn, you can also specify config options here
            // 'host' => 'example.com',
            // 'port' => 1000,
            // 'vhost' => '/',
            // 'user' => 'user',
            // 'pass' => 'pass',
            // 'persisted' => false,
        ],
    ],
];
