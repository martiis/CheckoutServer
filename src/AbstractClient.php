<?php

namespace Martiis\CheckoutServer;

use GuzzleHttp\Client;

abstract class AbstractClient
{
    /**
     * @var Client
     */
    private $client;

    /**
     * AbstractClient constructor.
     */
    final public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @return string
     */
    protected function getHost()
    {
        return '127.0.0.1';
    }

    /**
     * @return Client
     */
    protected function getClient()
    {
        return $this->client;
    }

    /**
     * @param string $method
     * @param mixed  $argument
     */
    protected function send($method, $argument = null)
    {
        $this
            ->getClient()
            ->post(
                $this->getUri($method),
                $argument === null ? [] : ['body' => json_encode($argument)]
            );
    }

    /**
     * Formats uri for client.
     *
     * @param string $method
     *
     * @return string
     */
    private function getUri($method)
    {
        return $this->getHost() . '/' . strtolower($method);
    }
}
