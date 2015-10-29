<?php

/*
 * This file is part of the CheckoutServer package.
 *
 * (c) Martynas Sudintas <martynas.sudintas@ongr.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Martiis\CheckoutServer;

interface Payment2QueueClientInterface
{
    /**
     * Asks queue to send item to storage.
     *
     * @param mixed $item
     */
    public function sendToStorage($item);
}
