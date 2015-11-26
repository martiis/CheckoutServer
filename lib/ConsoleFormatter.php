<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Martiis\Library;

use Symfony\Component\Console\Formatter\OutputFormatter;

class ConsoleFormatter extends OutputFormatter
{
    /**
     * {@inheritdoc}
     */
    public function format($message)
    {
        return date("[Y-m-d H:i:s] ") . parent::format($message);
    }
}
