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
use Martiis\CheckoutServer\SocketPort;
use Martiis\CheckoutServer\StorageClientInterface;

class Basket2StorageClient extends AbstractClient implements StorageClientInterface
{
    /**
     * {@inheritdoc}
     */
    public function save($item)
    {
        $this->send(__FUNCTION__, $item);
    }

    /**
     * {@inheritdoc}
     */
    public function getPort()
    {
        return SocketPort::STORAGE;
    }
}
