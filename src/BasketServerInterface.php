<?php

namespace Martiis\CheckoutServer;

interface BasketServerInterface extends ServerInterface
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
}
