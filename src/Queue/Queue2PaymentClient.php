<?php

/*
 * This file is part of the CheckoutServer package.
 *
 * (c) Martynas Sudintas <martynas.sudintas@ongr.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Martiis\CheckoutServer\Queue;

use Martiis\CheckoutServer\AbstractClient;
use Martiis\CheckoutServer\Queue2PaymentClientInterface;
use Martiis\CheckoutServer\SocketPort;
use React\EventLoop\Factory;
use React\Stream\Stream;

class Queue2PaymentClient extends AbstractClient implements Queue2PaymentClientInterface
{
    /**
     * {@inheritdoc}
     */
    public function authorizeItem($item)
    {
        $loop = Factory::create();
        $conn = new Stream($this->getClient(), $loop);
        $conn->write('authorizeItem ' . $item);

        $loop->run();
    }

    /**
     * {@inheritdoc}
     */
    public function getPort()
    {
        return SocketPort::PAYMENT;
    }
}
