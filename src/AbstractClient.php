<?php

namespace Martiis\CheckoutServer;

use Hprose\Http\Client as HproseHttpClient;

abstract class AbstractClient
{
    /**
     * @var resource
     */
    private $client;

    final public function __construct()
    {
        $this->client = new HproseHttpClient(sprintf('http://%s:%s', $this->getHost(), $this->getPort()));
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
    protected function send($method, $argument = null)
    {
        $arg = [];
        if ($argument !== null) {
            $arg[] = $argument;
        }

        $this->client->invoke($method, $arg);
    }
}
