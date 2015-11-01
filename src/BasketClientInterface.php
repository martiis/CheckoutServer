<?php

namespace Martiis\CheckoutServer;

interface BasketClientInterface
{
    /**
     * Adds item to basket.
     *
     * @param string $item
     */
    public function add($item);

    /**
     * Removes item from basket.
     *
     * @param string $item
     */
    public function remove($item);

    /**
     * Cleans out basket.
     */
    public function clean();

    /**
     * Basket checkout.
     */
    public function checkout();
}
