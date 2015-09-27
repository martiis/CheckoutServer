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

use React\EventLoop\Factory;
use React\Socket\Connection;
use React\Socket\Server;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PaymentProcessCommand extends AbstractProcessCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('process:payment')
            ->setDescription("Handles payments and approves product queue to storage.");
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $loop = Factory::create();
        $socket = new Server($loop);
        $socket->on('connection', [$this, 'onConnection']);
        $socket->listen('4001');

        $output->writeln('<comment>Payment process is running on port</comment> <info>4001</info>');
        $loop->run();
    }

    /**
     * {@inheritdoc}
     */
    public function onConnection(Connection $connection)
    {
        parent::onConnection($connection);
        $connection->write("#### Payment process #####\n");
    }
}
