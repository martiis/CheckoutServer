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

use React\Socket\Connection;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AbstractProcessCommand extends LoggerAwareCommand
{
    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * {@inheritdoc}
     */
    public function run(InputInterface $input, OutputInterface $output)
    {
        $this->setOutput($output);
        $this->getLogger()->debug('process started', ['process' => $this->getName()]);
        $exitCode = parent::run($input, $output);
        $this->getLogger()->debug('process quit', ['process' => $this->getName()]);

        return $exitCode;
    }

    /**
     * @param Connection $connection
     */
    public function onConnection(Connection $connection)
    {
        $address = $connection->getRemoteAddress();
        $this
            ->getOutput()
            ->writeln(sprintf("<comment>New connection from </comment>%s", $address));
        $this->getLogger()->debug('new connection', ['process' => $this->getName(), 'address' => $address]);
    }

    /**
     * @return OutputInterface
     */
    protected function getOutput()
    {
        return $this->output;
    }

    /**
     * @param OutputInterface $output
     */
    private function setOutput($output)
    {
        $this->output = $output;
    }
}
