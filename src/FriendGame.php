<?php

namespace Poker;

use Poker\Kernel\Judge;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FriendGame extends GameCommand
{
    use GameTrait;

    /**
     * Configures the current command.
     */
    public function configure()
    {
        $this->setName('start')
             ->setDescription('Start the game with you and you friend.')
             ->addArgument(
                'number',
                InputArgument::REQUIRED,
                'Set the player number of the game.'
            )
             ->addArgument(
                'names',
                InputArgument::IS_ARRAY,
                'Set the player name.'
            );
    }

    /**
     * Executes the current command.
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $number = $input->getArgument('number');
        $names = $input->getArgument('names');

        if ($number < count($names)) {
            $output->writeln($this->error("The names amount more than gaven number"));
        } else {
            $output->writeln($this->info("Although names not enough, i still execute the program, thanks me."));
        }

        for ($i=0; $i < count($names); $i++) {
            $hand = $this->random->generateHand();
            $hands[] = $hand;

            $rows[] = [$names[$i], implode(' ', $hand)];
            $data[] = [$names[$i], $this->transfer->toFlowers(implode(' ', $hand))];
        }

        $this->exercuteGame($input, $output, $data, $rows, $hands);
    }
}
