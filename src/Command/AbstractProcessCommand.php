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

use React\EventLoop\Factory;
use React\Socket\Connection;
use React\Socket\Server;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractProcessCommand extends LoggerAwareCommand
{
    /**
     * @var array
     */
    private $colors = ['red', 'green', 'yellow', 'blue', 'magenta', 'cyan'];

    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @var int
     */
    private $port;

    /**
     * {@inheritdoc}
     */
    public function run(InputInterface $input, OutputInterface $output)
    {
        $this->setOutput($output);
        $this->getLogger()->debug('process started', ['process' => $this->getName()]);

        return parent::run($input, $output);
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $loop = Factory::create();
        $socket = new Server($loop);
        $socket->on('connection', [$this, 'onConnection']);
        $socket->listen($this->getPort());

        $output->writeln("<comment>{$this->getName()} is running on port</comment> <info>{$this->getPort()}</info>");
        $loop->run();
    }

    /**
     * Executes when connection is made.
     *
     * @param Connection $connection
     */
    public function onConnection(Connection $connection)
    {
        $address = $connection->getRemoteAddress();

        $this
            ->getLogger()
            ->debug('new connection', ['command' => $this->getName(), 'address' => $address]);

        $color = $this->getColor();
        $this->getOutput()->writeln(sprintf("<fg=%s>%s connected</>", $color, $address));

        $connection->write("#### {$this->getName()} #####\n");
        $connection->on('data', [$this, 'onData']);

        $ref = $this;
        $connection->on('close', function (Connection $connection) use ($ref, $color, $address) {
            $ref
                ->getOutput()
                ->writeln(sprintf("<fg=%s>%s closed</>", $color, $address));
            $ref
                ->getLogger()
                ->debug('closed connection', ['command' => $ref->getName(), 'address' => $address]);
            $ref->returnColor($color);
        });
    }

    /**
     * Executes on data event
     *
     * @param mixed      $data
     * @param Connection $connection
     *
     * @return null|bool
     */
    public function onData($data, Connection $connection)
    {
        if (trim($data) === 'quit') {
            $connection->close();

            return false;
        }
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

    /**
     * @return string
     */
    public function getColor()
    {
        $color = array_shift($this->colors);

        return $color ? $color : 'white';
    }

    /**
     * @param $color
     */
    public function returnColor($color)
    {
        if ($color !== 'white') {
            $this->colors[] = $color;
        }
    }

    /**
     * @return int
     *
     * @throws \DomainException
     */
    public function getPort()
    {
        if (!$this->port) {
            throw new \DomainException('Port for command `' . $this->getName() . '` is not set in configuration.');
        }

        return $this->port;
    }

    /**
     * @param int $port
     *
     * @return $this
     */
    public function setPort($port)
    {
        $this->port = $port;

        return $this;
    }
}
