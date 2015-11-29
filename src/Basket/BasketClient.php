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
use Martiis\CheckoutServer\BasketClientInterface;
use Martiis\CheckoutServer\SocketPort;

class BasketClient extends AbstractClient implements BasketClientInterface
{
    /**
     * {@inheritdoc}
     */
    protected function getExchange()
    {
        return 'basket';
    }

    /**
     * {@inheritdoc}
     */
    public function add($item)
    {
        $this->send(__FUNCTION__, $item);
    }

    /**
     * {@inheritdoc}
     */
    public function remove($item)
    {
        $this->send(__FUNCTION__, $item);
    }

    /**
     * {@inheritdoc}
     */
    public function clean()
    {
        $this->send(__FUNCTION__);
    }

    /**
     * {@inheritdoc}
     */
    public function checkout()
    {
        $this->send(__FUNCTION__);
    }
}
