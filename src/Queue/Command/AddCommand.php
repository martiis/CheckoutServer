<?php

namespace Martiis\CheckoutServer\Queue\Command;

use Martiis\CheckoutServer\Queue\QueueClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('queue:add')
            ->setDescription('Adds item to queue')
            ->addArgument(
                'item',
                InputArgument::REQUIRED,
                'Item value'
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $client = new QueueClient();
        $client->add($input->getArgument('item'));
    }
}
