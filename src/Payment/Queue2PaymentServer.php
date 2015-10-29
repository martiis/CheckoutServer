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

use Martiis\CheckoutServer\AbstractServer;
use Martiis\CheckoutServer\Queue2PaymentServerInterface;
use Martiis\CheckoutServer\SocketPort;

class Queue2PaymentServer extends AbstractServer implements Queue2PaymentServerInterface
{
    /**
     * {@inheritdoc}
     */
    public function authorizeItem($data)
    {
        $this->getOutput()->writeln('Payment: Recieved ' . $data . '. Authorizing....');
        sleep(3);
        $this->getOutput()->writeln('Payment: Authorized. pinging queue...');
        $client = new Payment2QueueClient();
        $client->sendToStorage($data);
    }

    /**
     * {@inheritdoc}
     */
    public function getPort()
    {
        return SocketPort::PAYMENT;
    }
}
