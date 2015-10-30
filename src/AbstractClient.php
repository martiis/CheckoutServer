<?php

namespace Martiis\CheckoutServer;

use React\EventLoop\Factory;
use React\Stream\Stream;

abstract class AbstractClient
{
    /**
     * @var resource
     */
    private $client;

    final public function __construct()
    {
        $this->client = @stream_socket_client(sprintf('%s:%s', $this->getHost(), $this->getPort()));
    }

    /**
     * @return string
     */
    protected function getHost()
    {
        return '127.0.0.1';
    }

    /**
     * @return int
     */
    abstract public function getPort();

    /**
     * @return bool
     */
    public function isConnected()
    {
        return $this->client !== false;
    }

    /**
     * @return resource
     */
    protected function getClient()
    {
        if (!$this->isConnected()) {
            throw new \LogicException('Client is not connected!');
        }

        return $this->client;
    }

    /**
     * @param string $method
     * @param mixed  $argument
     */
    protected function send($method, $argument)
    {
        $loop = Factory::create();
        $conn = new Stream($this->getClient(), $loop);
        $conn->write(sprintf('%s %s', $method, json_encode($argument)));
        $loop->tick();
    }
}
