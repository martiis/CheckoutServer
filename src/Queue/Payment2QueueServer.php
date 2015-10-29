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

use Martiis\CheckoutServer\AbstractServer;
use Martiis\CheckoutServer\Payment2QueueServerInterface;
use Martiis\CheckoutServer\SocketPort;

class Payment2QueueServer extends AbstractServer implements Payment2QueueServerInterface
{
    /**
     * {@inheritdoc}
     */
    public function sendToStorage($item)
    {
        $this->getOutput()->writeln('Queue: sending ' . $item . ' to storage...');
    }

    /**
     * {@inheritdoc}
     */
    public function getPort()
    {
        return SocketPort::QUEUE;
    }
}
