<?php

require_once __DIR__ . '/app/bootstrap.php';

use Symfony\Component\Console\Output\StreamOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Martiis\CheckoutServer\Basket\BasketServer;
use Martiis\Library\ConsoleFormatter;

$app = new Silex\Application(['debug' => true]);

$app->post('/basket/{method}', function (Request $request, $method) use ($app) {
    $basket = new BasketServer();

    if (!method_exists($basket, $method)) {
        return new JsonResponse(
            ['message' => Response::$statusTexts[Response::HTTP_BAD_REQUEST]],
            Response::HTTP_BAD_REQUEST
        );
    }

    $stream = fopen('log_basket.txt', 'a+');
    $basket->setOutput(new StreamOutput($stream, OutputInterface::VERBOSITY_NORMAL, null, new ConsoleFormatter()));

    $args = json_decode($request->getContent());
    if ($args !== null) {
        $basket->{$method}($args);
    } else {
        $basket->{$method}();
    }
    fclose($stream);

    return new JsonResponse(['message' => 'ok']);
})->convert('method', function ($value) {
    return strtolower($value);
});

$app->run();
