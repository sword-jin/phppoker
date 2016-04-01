<?php

namespace Poker;

use Faker\Factory;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RandomGame extends GameCommand
{
    use GameTrait;

    /**
     * Configures the current command.
     */
    public function configure()
    {
        $this->setName('random')
             ->setDescription('Just random some people and start a poker game.')
             ->addOption('number', null, InputOption::VALUE_OPTIONAL, 'set player number of this game.', 2);
    }

    /**
     * Executes the current command.
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $number = $input->getOption('number');

        $faker = Factory::create();

        for ($i=0; $i < $number; $i++) {
            $username = $faker->firstname;
            $hand = $this->random->generateHand();
            $hands[] = $hand;

            $rows[] = [$username, implode(' ', $hand)];
            $data[] = [$username, $this->transfer->toFlowers(implode(' ', $hand))];
        }

        $this->exercuteGame($input, $output, $data, $rows, $hands);
    }
}
