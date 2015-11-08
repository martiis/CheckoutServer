<?php

require_once __DIR__ . '/app/bootstrap.php';

use Martiis\CheckoutServer\Storage\StorageServer;
use Hprose\Http\Server as HproseHttpServer;
use Symfony\Component\Console\Output\ConsoleOutput;

$storage = new StorageServer();
$storage->setOutput(new ConsoleOutput());

$server = new HproseHttpServer();
$server->add($storage);
$server->start();
