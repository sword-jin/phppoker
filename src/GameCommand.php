<?php

namespace Poker;

use Poker\Tools\Transfer;
use Poker\Tools\RandomGenerator;
use Symfony\Component\Console\Command\Command;

class GameCommand extends Command
{
    /**
     * @var \Poker\Tools\Transfer
     */
    protected $transfer;

    /**
     * @var \Poker\Tools\RandomGenerator
     */
    protected $random;

    /**
     * Just instance some dependencies
     */
    public function __construct()
    {
        parent::__construct();

        $this->transfer = Transfer::getIns();
        $this->random = new RandomGenerator;
    }

    /**
     * Get the result to output.
     *
     * @param  string $grade
     * @param  array  $winners
     *
     * @return string
     */
    public function getResult($grade, $winners)
    {
        $results = count($winners) == 1 ? 'Winner: ' : 'Games drawn, Winners: ';

        $results .= implode(', ', $winners) . "\n" . $grade;

        return $this->info($results);
    }

    /**
     * Display info message.
     *
     * @param  string $string
     *
     * @return string
     */
    protected function info($string)
    {
        return "<info>$string</info>";
    }

    /**
     * Display comment message.
     *
     * @param  string $string
     *
     * @return string
     */
    protected function comment($string)
    {
        return "<comment>$string</comment>";
    }

    /**
     * Display error message.
     *
     * @param  string $string
     *
     * @return string
     */
    protected function error($string)
    {
        return "<error>$string</error>";
    }

    /**
     * Let programe sleep for while.
     *
     * @param  int $seconds
     */
    protected function sleep($seconds = 1)
    {
        sleep($seconds);
    }
}
