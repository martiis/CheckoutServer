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
        list($data, $connection) = func_get_args();
        $connection->write("Payment: recieved item...\nPayment: authorizing...");
        sleep(3);
        $connection->write("Done\nPayment: noticing queue.");
    }

    /**
     * {@inheritdoc}
     */
    public function getPort()
    {
        return SocketPort::PAYMENT;
    }
}
