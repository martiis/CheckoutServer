<?php

require_once __DIR__ . '/app/bootstrap.php';

use Symfony\Component\Console\Output\StreamOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Martiis\CheckoutServer\Payment\PaymentServer;
use Martiis\Library\ConsoleFormatter;

$app = new Silex\Application(['debug' => true]);

$app->post('/payment/{method}', function (Request $request, $method) use ($app) {
    $payment = new PaymentServer();

    if (!method_exists($payment, $method)) {
        return new JsonResponse(
            ['message' => Response::$statusTexts[Response::HTTP_BAD_REQUEST]],
            Response::HTTP_BAD_REQUEST
        );
    }

    $stream = fopen('log_payment.txt', 'a+');
    $payment->setOutput(new StreamOutput($stream, OutputInterface::VERBOSITY_NORMAL, null, new ConsoleFormatter()));

    $args = json_decode($request->getContent());
    if ($args !== null) {
        $payment->{$method}($args);
    } else {
        $payment->{$method}();
    }
    fclose($stream);

    return new JsonResponse(['message' => 'ok']);
})->convert('method', function ($value) {
    return strtolower($value);
});

$app->run();
