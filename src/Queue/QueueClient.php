<?php

namespace Martiis\CheckoutServer\Queue;

use Martiis\CheckoutServer\AbstractClient;
use Martiis\CheckoutServer\QueueClientInterface;
use Martiis\CheckoutServer\SocketPort;
use React\EventLoop\Factory;
use React\Stream\Stream;

class QueueClient extends AbstractClient implements QueueClientInterface
{
    /**
     * {@inheritdoc}
     */
    public function getPort()
    {
        return SocketPort::QUEUE;
    }

    /**
     * {@inheritdoc}
     */
    public function add($item)
    {
        $this->send(__FUNCTION__, $item);
    }

    /**
     * {@inheritdoc}
     */
    public function approve($key)
    {
        $this->send(__FUNCTION__, $key);
    }
}
