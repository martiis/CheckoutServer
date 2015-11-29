<?php

require_once __DIR__ . '/app/bootstrap.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Console\Output\ConsoleOutput;
use Martiis\CheckoutServer\Storage\StorageServer;

$connection = new AMQPStreamConnection('localhost', 5672, 'user', 'user');
$channel = $connection->channel();
$channel->exchange_declare('storage', 'direct', false, false, false);
list($qName, ,) = $channel->queue_declare("", false, false, true, false);

$output = new ConsoleOutput();
$storage = new StorageServer();
$storage->setOutput($output);

$methods = get_class_methods('Martiis\CheckoutServer\Basket\BasketServer');
foreach ($methods as $method) {
    $channel->queue_bind($qName, 'storage', strtolower($method));
}

$callback = function (AMQPMessage $msg) use ($storage, $output) {
    $method = $msg->delivery_info['routing_key'];
    if (method_exists($storage, $method)) {
        $args = json_decode($msg->body, true);

        $output->writeln(' [x] Executing ' . $method);
        if ($args !== null) {
            $storage->{$method}($args);
        } else {
            $storage->{$method}();
        }
    } else {
        throw new \BadMethodCallException($method . ' does not exist!');
    }
};


$channel->basic_consume($qName, '', false, true, false, false, $callback);
$output->writeln(' [*] Waiting for storage actions. To exit press CTRL+C');

while (count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();
