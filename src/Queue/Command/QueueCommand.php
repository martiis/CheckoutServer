<?php


namespace Martiis\CheckoutServer\Queue\Command;

use Martiis\CheckoutServer\Queue\QueueServer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class QueueCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('server:queue')
            ->setDescription('Starts up queue server');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $server = new QueueServer();
        $server->run($output);
    }
}
