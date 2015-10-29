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

interface Queue2PaymentServerInterface extends ServerInterface
{
    /**
     * Sends item to payment for authorization.
     *
     * @param mixed $data
     */
    public function authorizeItem($data);
}
