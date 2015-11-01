<?php


namespace Martiis\CheckoutServer;

interface Payment2BasketServerInterface extends ServerInterface
{
    /**
     * Approves basket for checkout.
     */
    public function approve();
}
