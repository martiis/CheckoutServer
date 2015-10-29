<?php


namespace Martiis\CheckoutServer\Queue\Command;

use Martiis\CheckoutServer\Queue\Queue2PaymentClient;
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
            ->setName('martiis:add')
            ->setDescription('Adds item to queue.')
            ->addArgument(
                'value',
                InputArgument::REQUIRED,
                'Item value'
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $client = new Queue2PaymentClient();

        if (!$client->isConnected()) {
            $output->writeln('<error>Was unable to make connection!</error>');
            return 1;
        }

        if ($client->authorizeItem($input->getArgument('value'))) {
            $output->writeln('Sent new item to payment!');
        } else {
            $output->writeln('Failed to send item..');
        }

        return 0;
    }
}
