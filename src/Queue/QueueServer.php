<?php


namespace Martiis\CheckoutServer\Queue;

use Martiis\CheckoutServer\AbstractServer;
use Martiis\CheckoutServer\QueueServerInterface;
use Martiis\CheckoutServer\SocketPort;

class QueueServer extends AbstractServer implements QueueServerInterface
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
        return SocketPort::QUEUE;
    }

    /**
     * {@inheritdoc}
     */
    public function add($item)
    {
        $this->queue[] = $item;
        end($this->queue);
        $key = key($this->queue);
        $this->getOutput() && $this->getOutput()->writeln("Queue: inserted $key => $item");
        var_dump($this->queue);

        $client = new Queue2PaymentClient();
        $client->authorizeItem([$key => $item]);
    }

    /**
     * {@inheritdoc}
     */
    public function approve($key)
    {
        $item = $this->queue[$key];
        unset($this->queue[$key]);

        $this->getOutput() && $this->getOutput()->writeln("Queue: taken out $key => $item");
        var_dump($this->queue);

        $client = new Queue2StorageClient();
        $client->saveItem($item);
    }
}
