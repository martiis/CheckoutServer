<?php

namespace Martiis\CheckoutServer;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;

abstract class AbstractClient
{
    /**
     * @var AMQPStreamConnection
     */
    private $connection;

    /**
     * @var AMQPChannel
     */
    private $channel;

    /**
     * AbstractClient constructor.
     */
    final public function __construct()
    {
        $this->connection = new AMQPStreamConnection('localhost', 5672, 'user', 'user');
        $this->channel = $this->connection->channel();
        $this->channel->exchange_declare($this->getExchange(), 'direct', false, false, false);
    }

    /**
     * AbstractClient destructor.
     */
    final public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }

    /**
     * Exchange name for client.
     *
     * @return string
     */
    abstract protected function getExchange();

    /**
     * @return AMQPChannel
     */
    protected function getChannel()
    {
        return $this->channel;
    }

    /**
     * @param string $method
     * @param mixed  $argument
     */
    protected function send($method, $argument = null)
    {
        $this
            ->getChannel()
            ->basic_publish(
                new AMQPMessage($argument === null ? '' : json_encode($argument)),
                $this->getExchange(),
                strtolower($method)
            );
    }
}
