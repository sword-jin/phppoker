<?php

use Faker\Factory;
use Poker\Kernel\Judge;
use Poker\Tools\RandomGenerator;

class JudgeTest extends PHPUnit_Framework_TestCase
{
    public function __construct()
    {
        $this->generator = new RandomGenerator;
        $this->faker = Factory::create();
    }

    public function test_can_get_winner_name_and_hand_category()
    {
        for ($i=0; $i < 2; $i++) {
            $username = $this->faker->firstname;
            $hand = $this->generator->generateHand();
            $hands[] = $hand;

            $rows[] = [$username, implode(' ', $hand)];
        }
        $hands[] = ['AS', 'KS', 'QS', 'JS', 'TS'];
        $rows[] = ['RryLee', 'AS KS QS JS TS'];
        $rows[] = ['ChenXi', 'AS KS QS JS TS'];

        $judger = new Judge($hands, $rows);

        $excepted = [
            'Oh, gad, Straight flush',
            [
                'RryLee',
                'ChenXi'
            ]
        ];

        $this->assertEquals($excepted, $judger->getAllMax());
    }
}
