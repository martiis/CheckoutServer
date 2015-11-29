<?php

require_once __DIR__ . '/app/bootstrap.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Console\Output\ConsoleOutput;
use Martiis\CheckoutServer\Basket\BasketServer;

$connection = new AMQPStreamConnection('localhost', 5672, 'user', 'user');
$channel = $connection->channel();
$channel->exchange_declare('basket', 'direct', false, false, false);
list($qName, ,) = $channel->queue_declare("", false, false, true, false);

$output = new ConsoleOutput();
$basket = new BasketServer();
$basket->setOutput($output);

$methods = get_class_methods('Martiis\CheckoutServer\Basket\BasketServer');
foreach ($methods as $method) {
    $channel->queue_bind($qName, 'basket', strtolower($method));
}

$callback = function (AMQPMessage $msg) use ($basket, $output) {
    $method = $msg->delivery_info['routing_key'];
    if (method_exists($basket, $method)) {
        $args = json_decode($msg->body, true);
        $output->writeln(' [x] Executing ' . $method);
        $basket->{$method}($args);
    } else {
        throw new \BadMethodCallException($method . ' does not exist!');
    }
};


$channel->basic_consume($qName, '', false, true, false, false, $callback);
$output->writeln(' [*] Waiting for basket actions. To exit press CTRL+C');

while (count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();
