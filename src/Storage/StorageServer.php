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
use Martiis\CheckoutServer\SocketPort;
use Martiis\CheckoutServer\StorageServerInterface;

class StorageServer extends AbstractServer implements StorageServerInterface
{
    const FNAME = 'storage.txt';

    /**
     * @WebMethod
     *
     * @desc Saves item in local storage.
     *
     * @param array $item
     *
     * @return void
     */
    public function save($item)
    {


        $date = date('Y-m-d H:i:s');
        $this->getOutput()->writeln("<info>Storage</info>: saving $date order.");

        file_put_contents(static::FNAME, "==== $date ====\n", FILE_APPEND);
        foreach ($item as $row) {
            file_put_contents(static::FNAME, "{$row[0]}\t\t\t{$row[1]}", FILE_APPEND);
        }
        file_put_contents(static::FNAME, "\n", FILE_APPEND);
    }

    /**
     * {@inheritdoc}
     */
    public function getPort()
    {
        return SocketPort::STORAGE;
    }
}
