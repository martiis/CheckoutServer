<?php

/*
 * This file is part of the CheckoutServer package.
 *
 * (c) Martynas Sudintas <martynas.sudintas@ongr.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Martiis\CheckoutServer\Storage;

use Martiis\CheckoutServer\AbstractServer;
use Martiis\CheckoutServer\Queue2StorageServerInterface;
use Martiis\CheckoutServer\SocketPort;
use React\Socket\Connection;

class Queue2StorageServer extends AbstractServer implements Queue2StorageServerInterface
{
    /**
     * @var array
     */
    private $storage = [];

    /**
     * {@inheritdoc}
     */
    public function saveItem($item)
    {
        $this->getOutput()->writeln('Storage: saving ' . $item);
        $this->storage[] = $item;
    }

    /**
     * {@inheritdoc}
     */
    public function getPort()
    {
        return SocketPort::STORAGE;
    }
}
