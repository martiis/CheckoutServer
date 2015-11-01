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
use Martiis\CheckoutServer\PaymentServerInterface;
use Martiis\CheckoutServer\SocketPort;

class PaymentServer extends AbstractServer implements PaymentServerInterface
{
    /**
     * {@inheritdoc}
     */
    public function getPort()
    {
        return SocketPort::PAYMENT;
    }

    /**
     * {@inheritdoc}
     */
    public function checkout($data)
    {
        $this->getOutput()->writeln('<comment>Payment</comment>: calculating money...');
        sleep(2);

        $price = 0;
        foreach ($data as $item) {
            $price += $item[1];
        }

        $this
            ->getOutput()
            ->writeln("<info>Payment</info>: payed <info>$price</info>\n<comment>Payment</comment>: approving...");
        (new Payment2BasketClient())->approve();
    }
}
