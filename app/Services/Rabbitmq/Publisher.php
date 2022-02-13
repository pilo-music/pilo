<?php

namespace App\Services\Rabbitmq;

use Illuminate\Support\Facades\Log;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Publisher
{

    public function __construct(
        private $message,
        private $exchange = '',
        private $queue = '',
    )
    {

        $host = config('pilo.rabbitmq_host');
        $port = config('pilo.rabbitmq_port');
        $user = config('pilo.rabbitmq_user');
        $password = config('pilo.rabbitmq_password');

        $connection = new AMQPStreamConnection($host, $port, $user, $password);
        $channel = $connection->channel();

        $msg = new AMQPMessage(json_encode($this->message), array('delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT));
        $channel->basic_publish($msg, $this->exchange, $this->queue);

        try {
            $channel->close();
            $connection->close();
        } catch (\Exception $e) {
            Log::error($e);
        }
    }
}
