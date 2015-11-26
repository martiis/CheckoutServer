<?php

namespace Martiis\CheckoutServer;

use Hprose\Http\Client as HproseHttpClient;

abstract class AbstractClient
{
    /**
     * @var \SoapClient
     */
    private $client;

    /**
     * AbstractClient constructor.
     */
    final public function __construct()
    {
        $this->client = new \SoapClient(
            "http://localhost:{$this->getPort()}?wsdl",
            [
                'uri' => 'http://foo.bar/',
                'location' => "http://localhost:{$this->getPort()}",
                'trace' => true,
                'cache_wsdl' => WSDL_CACHE_NONE
            ]
        );
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
        return (bool)$this->client;
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
        if ($argument === null) {
            $this->client->{$method}();
        } else {
            $this->client->{$method}(json_encode($argument));
        }
    }
}
