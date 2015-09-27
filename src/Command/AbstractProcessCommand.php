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

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AbstractProcessCommand extends Command
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

        return parent::run($input, $output);
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
