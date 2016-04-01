<?php

namespace Poker;

use Poker\Kernel\Judge;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

trait GameTrait
{
    /**
     * Just refctor code.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface  $input
     * @param  \Symfony\Component\Console\Output\OutputInterface $output
     * @param  array $data
     * @param  array $rows
     * @param  array $hands
     */
    public function exercuteGame(InputInterface $input, OutputInterface $output, $data, $rows, $hands)
    {
        $output->writeln($this->comment('Please wait...'));
        $this->sleep();

        $table = new Table($output);
        $table->setHeaders(['Username', 'Hand']);
        $table->setRows($data);
        $table->render();

        $judger = new Judge($hands, $rows);

        list($grade, $winners) = $judger->getAllMax();

        $output->writeln($this->comment('The results were as follows:'));
        $this->sleep();
        $output->writeln($this->getResult($grade, $winners));
    }
}
