<?php

namespace Martiis\CheckoutServer;

interface Basket2PaymentServerInterface extends ServerInterface
{
    /**
     * Basket checkout.
     */
    public function checkout();
}
