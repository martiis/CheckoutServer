<?php

namespace Martiis\CheckoutServer\Queue\Command;

use Martiis\CheckoutServer\Queue\Payment2QueueServer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Payment2QueueCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('martiis:payment:queue')
            ->setDescription('Starts up payment 2 queue server');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $server = new Payment2QueueServer();
        $server->run();
    }
}
