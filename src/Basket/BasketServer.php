<?php

/*
 * This file is part of the CheckoutServer package.
 *
 * (c) Martynas Sudintas <martynas.sudintas@ongr.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Martiis\CheckoutServer\Basket;

use Martiis\CheckoutServer\AbstractServer;
use Martiis\CheckoutServer\Basket2PaymentServerInterface;
use Martiis\CheckoutServer\BasketServerInterface;
use Martiis\CheckoutServer\Payment2BasketServerInterface;
use Martiis\CheckoutServer\Basket\Basket2StorageClient;
use Martiis\CheckoutServer\SocketPort;

class BasketServer extends AbstractServer implements
    BasketServerInterface,
    Basket2PaymentServerInterface,
    Payment2BasketServerInterface
{
    /**
     * @var array
     */
    private $queue = [];

    /**
     * {@inheritdoc}
     */
    public function getPort()
    {
        return SocketPort::BASKET;
    }

    /**
     * {@inheritdoc}
     */
    public function add($item)
    {
        $this->queue[] = $item;
        end($this->queue);
        $key = key($this->queue);
        $this->getOutput() && $this
            ->getOutput()
            ->writeln("<info>Basket</info>: inserted <comment>$key => $item[0], $item[1]</comment>");
    }

    /**
     * {@inheritdoc}
     */
    public function remove($item)
    {
        $removed = false;

        foreach ($this->queue as $key => $basketItem) {
            if ($basketItem[0] === $item) {
                unset($this->queue[$key]);
                $removed = true;
                $this->getOutput()->writeln("<info>Basket</info>: removed $item");
                break;
            }
        }

        if (!$removed) {
            $this->getOutput()->writeln("<error>Basket</error>: item $item not found!");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function clean()
    {
        $this->queue = [];
        $this->getOutput()->writeln("<info>Basket</info>: clean");
    }

    /**
     * {@inheritdoc}
     */
    public function checkout()
    {
        (new Basket2PaymentClient())->checkout($this->queue);
        $this->getOutput()->writeln("<info>Basket</info>: sent to checkout");
    }

    /**
     * {@inheritdoc}
     */
    public function approve()
    {
        $this->getOutput()->writeln("<info>Basket</info>: payment approved!");
        (new Basket2StorageClient())->save($this->queue);
        $this->getOutput()->writeln('<info>Basket</info>: sent to storage!');
        $this->clean();
    }
}
