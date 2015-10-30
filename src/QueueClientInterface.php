<?php

namespace Martiis\CheckoutServer;

interface QueueClientInterface
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
