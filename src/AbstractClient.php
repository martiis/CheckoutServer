<?php

namespace Martiis\CheckoutServer;

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

    final public function __destruct()
    {
        fclose($this->client);
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
        return $this->client;
    }
}
