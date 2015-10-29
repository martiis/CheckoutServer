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

interface Queue2PaymentClientInterface
{
    /**
     * Sends item to authorization
     *
     * @param mixed $item
     */
    public function authorizeItem($item);
}
