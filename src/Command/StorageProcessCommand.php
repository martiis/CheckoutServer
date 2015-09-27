<?php

/*
 * This file is part of the CheckoutServer package.
 *
 * (c) Martynas Sudintas <martynas.sudintas@ongr.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Martiis\CheckoutServer\Command;

use Martiis\CheckoutServer\SocketPort;

class StorageProcessCommand extends AbstractProcessCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setPort(SocketPort::STORAGE)
            ->setName('process:storage')
            ->setDescription('Holds products that are ready to ship.');
    }
}
