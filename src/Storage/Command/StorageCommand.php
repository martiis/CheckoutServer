<?php

namespace Martiis\CheckoutServer\Storage\Command;

use Martiis\CheckoutServer\Storage\Queue2StorageServer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StorageCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('server:storage')
            ->setDescription('Starts up storage server');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $server = new Queue2StorageServer();
        $server->run($output);
    }
}
