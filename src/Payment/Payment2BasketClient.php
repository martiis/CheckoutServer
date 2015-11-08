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
use Martiis\CheckoutServer\Payment2BasketClientInterface;
use Martiis\CheckoutServer\SocketPort;

class Payment2BasketClient extends AbstractClient implements Payment2BasketClientInterface
{
    /**
     * {@inheritdoc}
     */
    public function getPort()
    {
        return SocketPort::BASKET . '/basket.php';
    }

    /**
     * {@inheritdoc}
     */
    public function approve()
    {
        $this->send(__FUNCTION__);
    }
}
