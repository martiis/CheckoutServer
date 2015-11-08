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
    const QUEUE_FNAME = 'queue.txt';

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
        list($name, $price) = $item;
        file_put_contents(self::QUEUE_FNAME, $name . ' ' . $price . "\n", FILE_APPEND);

        $this->getOutput() && $this
            ->getOutput()
            ->writeln("<info>Basket</info>: inserted <comment>$name, $price</comment>");
    }

    /**
     * {@inheritdoc}
     */
    public function remove($item)
    {
//        $removed = false;
//
//        foreach ($this->queue as $key => $basketItem) {
//            if ($basketItem[0] === $item) {
//                unset($this->queue[$key]);
//                $removed = true;
//                $this->getOutput()->writeln("<info>Basket</info>: removed $item");
//                break;
//            }
//        }
//
//        if (!$removed) {
//            $this->getOutput()->writeln("<error>Basket</error>: item $item not found!");
//        }
    }

    /**
     * {@inheritdoc}
     */
    public function clean()
    {
        file_put_contents(self::QUEUE_FNAME, '');
        $this->getOutput()->writeln("<info>Basket</info>: clean");
    }

    /**
     * {@inheritdoc}
     */
    public function checkout()
    {
        (new Basket2PaymentClient())->checkout($this->read());
        $this->getOutput()->writeln("<info>Basket</info>: sent to checkout");
    }

    /**
     * {@inheritdoc}
     */
    public function approve()
    {
        $this->getOutput()->writeln("<info>Basket</info>: payment approved!");
        (new Basket2StorageClient())->save($this->read());
        $this->getOutput()->writeln('<info>Basket</info>: sent to storage!');
        $this->clean();
    }

    private function read()
    {
        $queue = [];

        $resoure = fopen(self::QUEUE_FNAME, 'r');

        while(($buffer = fgets($resoure)) !== false) {
            $queue[] = explode(' ', $buffer, 2);
        }

        fclose($resoure);

        return $queue;
    }
}
