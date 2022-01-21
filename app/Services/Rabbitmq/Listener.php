<?php

namespace App\Services\Rabbitmq;

use PhpAmqpLib\Connection\AMQPStreamConnection;

class Listener
{
    /**
     * @throws \ErrorException
     */
    public function __construct(
        private $queue = '',
        private $no_ack = false,
        private $nowait = false,
        private $callback = null,
    )
    {

        $host = config('pilo.rabbitmq_host');
        $port = config('pilo.rabbitmq_port');
        $user = config('pilo.rabbitmq_user');
        $password = config('pilo.rabbitmq_password');

        $connection = new AMQPStreamConnection($host, $port, $user, $password);
        $channel = $connection->channel();
        $channel->basic_consume($this->queue, '', false, $this->no_ack, false, $this->nowait, function ($msg) {
            call_user_func($this->callback, $msg);
            if (!$this->no_ack) {
                $msg->ack();
            }
        });

        while ($channel->is_open()) {
            $channel->wait();
        }
    }
}
