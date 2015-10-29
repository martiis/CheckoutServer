<?php

/*
 * This file is part of the CheckoutServer package.
 *
 * (c) Martynas Sudintas <martynas.sudintas@ongr.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Martiis\CheckoutServer;

use React\EventLoop\Factory;
use React\Socket\Connection;
use React\Socket\Server;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractServer implements ServerInterface
{
    /**
     * Returns port for server.
     *
     * @return int
     */
    abstract public function getPort();

    /**
     * Routes request to method.
     *
     * @param mixed      $data
     * @param Connection $connection
     */
    public function routeMethod($data, Connection $connection)
    {
        echo 'called';

        list($method, $data) = explode(' ', $data, 2);
        if (method_exists($this, $method)) {
            $this->{$method}($data, $connection);
        } else {
            $connection->write("Error: `$method`` not found!");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function run(OutputInterface $output = null)
    {
        $loop = Factory::create();
        $socket = new Server($loop);
        $socket->listen($this->getPort());
        $socket->on('connection', function (Connection $connection) use ($output) {
            $output && $output->writeln('New connection!');
        });
        $socket->on('data', [$this, 'routeMethod']);

        $output && $output->writeln('<comment>Server running...</comment>');
        $loop->run();
    }
}
