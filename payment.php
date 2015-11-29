<?php

require_once __DIR__ . '/app/bootstrap.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Console\Output\ConsoleOutput;
use Martiis\CheckoutServer\Payment\PaymentServer;

$connection = new AMQPStreamConnection('localhost', 5672, 'user', 'user');
$channel = $connection->channel();
$channel->exchange_declare('payment', 'direct', false, false, false);
list($qName, ,) = $channel->queue_declare("", false, false, true, false);

$output = new ConsoleOutput();
$payment = new PaymentServer();
$payment->setOutput($output);

$methods = get_class_methods('Martiis\CheckoutServer\Basket\BasketServer');
foreach ($methods as $method) {
    $channel->queue_bind($qName, 'payment', strtolower($method));
}

$callback = function (AMQPMessage $msg) use ($payment, $output) {
    $method = $msg->delivery_info['routing_key'];
    if (method_exists($payment, $method)) {
        $args = json_decode($msg->body, true);

        $output->writeln(' [x] Executing ' . $method);
        if ($args !== null) {
            $payment->{$method}($args);
        } else {
            $payment->{$method}();
        }
    } else {
        throw new \BadMethodCallException($method . ' does not exist!');
    }
};


$channel->basic_consume($qName, '', false, true, false, false, $callback);
$output->writeln(' [*] Waiting for payment actions. To exit press CTRL+C');

while (count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();
