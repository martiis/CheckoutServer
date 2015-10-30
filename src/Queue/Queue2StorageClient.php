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
use Martiis\CheckoutServer\Queue2StorageClientInterface;
use Martiis\CheckoutServer\SocketPort;

class Queue2StorageClient extends AbstractClient implements Queue2StorageClientInterface
{
    /**
     * {@inheritdoc}
     */
    public function saveItem($item)
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
