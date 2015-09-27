<?php

/*
 * This file is part of the CheckoutServer package.
 *
 * (c) Martynas Sudintas <martynas.sudintas@ongr.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Martiis\CheckoutServer\Command;

use React\HttpClient\Factory;
use React\Socket\Connection;
use React\Socket\Server;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StorageProcessCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('process:storage')
            ->setDescription('Holds products that are ready to ship.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $loop = Factory::create();
        $socket = new Server($loop);
        $socket->on('connection', [$this, 'onConnection']);
        $socket->listen('4002');

        $output->writeln('<comment>Payment process is running on port</comment> <info>4002</info>');
        $loop->run();
    }

    /**
     * @param Connection $connection
     */
    public function onConnection(Connection $connection)
    {
        $this
            ->getOutput()
            ->writeln(sprintf("<comment>New connection from </comment>%s", $connection->getRemoteAddress()));
        $connection->write("#### Storage process #####\n");
    }
}
