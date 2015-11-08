<?php

require_once __DIR__ . '/app/bootstrap.php';

use Martiis\CheckoutServer\Basket\BasketServer;
use Hprose\Http\Server as HproseHttpServer;
use Symfony\Component\Console\Output\ConsoleOutput;

$basket = new BasketServer();
$basket->setOutput(new ConsoleOutput());

$server = new HproseHttpServer();
$server->add($basket);
$server->start();
