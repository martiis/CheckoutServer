<?php

require_once __DIR__ . '/app/bootstrap.php';

use Martiis\CheckoutServer\Payment\PaymentServer;
use Hprose\Http\Server as HproseHttpServer;
use Symfony\Component\Console\Output\ConsoleOutput;

$payment = new PaymentServer();
$payment->setOutput(new ConsoleOutput());

$server = new HproseHttpServer();
$server->add($payment);
$server->start();
