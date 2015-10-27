<?php

namespace Martiis\CheckoutServer\Payment\Command;

use Martiis\CheckoutServer\Payment\Queue2PaymentServer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Queue2PaymentCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('martiis:queue:payment')
            ->setDescription('Starts up queue 2 payment server');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $server = new Queue2PaymentServer();
        $server->run();
    }
}
