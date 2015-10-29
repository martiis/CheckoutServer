<?php

/*
 * This file is part of the CheckoutServer package.
 *
 * (c) Martynas Sudintas <martynas.sudintas@ongr.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Martiis\CheckoutServer;

use Symfony\Component\Console\Output\OutputInterface;

interface ServerInterface
{
    /**
     * Starts server listening on specific port.
     *
     * @param OutputInterface|null $output
     */
    public function run(OutputInterface $output = null);
}
