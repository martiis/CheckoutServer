<?php

/*
 * This file is part of the CheckoutServer package.
 *
 * (c) Martynas Sudintas <martynas.sudintas@ongr.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Martiis\CheckoutServer\Payment;

use Martiis\CheckoutServer\AbstractClient;
use Martiis\CheckoutServer\Payment2QueueClientInterface;
use Martiis\CheckoutServer\SocketPort;
use React\EventLoop\Factory;
use React\Stream\Stream;

class Payment2QueueClient extends AbstractClient implements Payment2QueueClientInterface
{
    public function sendToStorage($item)
    {
        $loop = Factory::create();
        $conn = new Stream($this->getClient(), $loop);
        $conn->write(sprintf('%s %s', 'sendToStorage', $item));
        $loop->tick();
    }

    /**
     * {@inheritdoc}
     */
    public function getPort()
    {
        return SocketPort::QUEUE;
    }
}
