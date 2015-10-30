<?php

namespace Martiis\CheckoutServer;

interface QueueServerInterface extends ServerInterface
{
    /**
     * @param string $item
     */
    public function add($item);

    /**
     * @param string|int $key
     */
    public function approve($key);
}
