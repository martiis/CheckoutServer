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

class Basket2PaymentClient extends AbstractClient implements Basket2PaymentClientInterface
{
    /**
     * {@inheritdoc}
     */
    protected function getHost()
    {
        return parent::getHost() . '/payment';
    }

    /**
     * {@inheritdoc}
     */
    public function checkout($data)
    {
        $this->send(__FUNCTION__, $data);
    }
}
