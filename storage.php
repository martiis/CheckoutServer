<?php

require_once __DIR__ . '/app/bootstrap.php';

use Symfony\Component\Console\Output\StreamOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Martiis\CheckoutServer\Storage\StorageServer;
use Martiis\Library\ConsoleFormatter;

$app = new Silex\Application(['debug' => true]);

$app->post('/storage/{method}', function (Request $request, $method) use ($app) {
    $storage = new StorageServer();

    if (!method_exists($storage, $method)) {
        return new JsonResponse(
            ['message' => Response::$statusTexts[Response::HTTP_BAD_REQUEST]],
            Response::HTTP_BAD_REQUEST
        );
    }

    $stream = fopen('log_storage.txt', 'a+');
    $storage->setOutput(new StreamOutput($stream, OutputInterface::VERBOSITY_NORMAL, null, new ConsoleFormatter()));

    $args = json_decode($request->getContent());
    if ($args !== null) {
        $storage->{$method}($args);
    } else {
        $storage->{$method}();
    }
    fclose($stream);

    return new JsonResponse(['message' => 'ok']);
})->convert('method', function ($value) {
    return strtolower($value);
});

$app->run();
