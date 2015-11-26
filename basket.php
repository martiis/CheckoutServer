<?php

require_once __DIR__ . '/app/bootstrap.php';

use Symfony\Component\Console\Output\StreamOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Martiis\CheckoutServer\Basket\BasketServer;
use Martiis\Library\ConsoleFormatter;
use WSDL\WSDLCreator;

$wsdl = new WSDLCreator('Martiis\CheckoutServer\Basket\BasketServer', 'http://localhost:8008/basket.php');
$wsdl->setNamespace("http://foo.bar");

if (isset($_GET['wsdl'])) {
    $wsdl->renderWSDL();
    exit;
}

try {
    $stream = fopen('log_basket.txt', 'a+');
    $basket = new BasketServer();
    $basket->setOutput(new StreamOutput($stream, OutputInterface::VERBOSITY_NORMAL, null, new ConsoleFormatter()));

    $server = new SoapServer(null, [
        'uri' => $wsdl->getNamespaceWithSanitizedClass(),
        'location' => $wsdl->getLocation(),
        'style' => SOAP_RPC,
        'use' => SOAP_LITERAL
    ]);
    $server->setObject($basket);
    $server->handle();
} catch (SoapFault $e) {
    print $e->getMessage();
} finally {
    fclose($stream);
}
