<?php

/*
 * This file is part of the CheckoutServer package.
 *
 * (c) Martynas Sudintas <martynas.sudintas@ongr.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Martiis\CheckoutServer\Basket;

use Martiis\CheckoutServer\AbstractClient;
use Martiis\CheckoutServer\Basket2PaymentClientInterface;
use Martiis\CheckoutServer\SocketPort;

class Basket2PaymentClient extends AbstractClient implements Basket2PaymentClientInterface
{
    /**
     * {@inheritdoc}
     */
    public function getPort()
    {
        return SocketPort::PAYMENT . '/payment.php';
    }

    /**
     * {@inheritdoc}
     */
    public function checkout($data)
    {
        $this->send(__FUNCTION__, $data);
    }
}
