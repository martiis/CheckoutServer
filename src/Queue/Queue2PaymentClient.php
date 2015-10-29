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

class Queue2PaymentClient extends AbstractClient implements Queue2PaymentClientInterface
{
    /**
     * {@inheritdoc}
     */
    public function authorizeItem($item)
    {
        return (bool)fwrite($this->getClient(), 'authorizeItem ' . $item);
    }

    /**
     * {@inheritdoc}
     */
    public function getPort()
    {
        return SocketPort::PAYMENT;
    }
}
