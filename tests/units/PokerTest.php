<?php

use Poker\Kernel\Poker;
use Poker\Tools\RandomGenerator;

class PokerTest extends PHPUnit_Framework_TestCase
{
    public function test_it_can_get_ranks_1()
    {
        $hands = [
            ['2S', '2H', '2D', '3C', '3H'],
            ['AS', '2H', '3D', '4C', '5H']
        ];

        $excepted = [
            [6, [2, 3]],
            ['2S 2H 2D 3C 3H']
        ];

        $this->assertEquals($excepted, (new Poker($hands))->getWinHands());
    }

    public function test_straight_flush_bigger_four_of_kind()
    {
        $hands = [
            ['2D', 'AD', '3D', '4D', '5D'],
            ['AS', 'AH', '3D', 'AC', 'AD']
        ];

        $excepted = [
            [8, [5]],
            ['2D AD 3D 4D 5D']
        ];

        $this->assertEquals($excepted, (new Poker($hands))->getWinHands());
    }

    public function test_four_of_kind_bigger_full_house()
    {
        $hands = [
            ['AS', 'AH', '3D', 'AC', 'AD'],
            ['2D', '2H', '3C', '3S', '3D']
        ];

        $excepted = [
            [7, [14, 3]],
            ['AS AH 3D AC AD']
        ];

        $this->assertEquals($excepted, (new Poker($hands))->getWinHands());
    }

    public function test_full_house_bigger_flush()
    {
        $hands = [
            ['2D', '2H', '3C', '3S', '3D'],
            ['3S', '6S', '6S', '8S', 'KS']
        ];

        $excepted = [
            [6, [3, 2]],
            ['2D 2H 3C 3S 3D']
        ];

        $this->assertEquals($excepted, (new Poker($hands))->getWinHands());
    }

    public function test_flush_bigger_straight()
    {
        $hands = [
            ['3S', '6S', '6S', '8S', 'KS'],
            ['2H', '3H', '4S', '5S', '6C']
        ];

        $excepted = [
            [5, [13, 8, 6, 6, 3]],
            ['3S 6S 6S 8S KS']
        ];

        $this->assertEquals($excepted, (new Poker($hands))->getWinHands());
    }

    public function test_straight_bigger_three_of_kind()
    {
        $hands = [
            ['2H', '3H', '4S', '5S', '6C'],
            ['2S', '2D', '2C', 'AD', '7S']
        ];

        $excepted = [
            [4, [6]],
            ['2H 3H 4S 5S 6C']
        ];

        $this->assertEquals($excepted, (new Poker($hands))->getWinHands());
    }

    public function test_three_of_kind_bigger_two_pair()
    {
        $hands = [
            ['2S', '2D', '2C', 'AD', '7S'],
            ['3S', '3C', '4D', '4D', 'TS']
        ];

        $excepted = [
            [3, [2, 14, 7]],
            ['2S 2D 2C AD 7S']
        ];

        $this->assertEquals($excepted, (new Poker($hands))->getWinHands());
    }

    public function test_two_pair_bigger_one_pair()
    {
        $hands = [
            ['3S', '3C', '4D', '4D', 'TS'],
            ['AS', 'KC', 'QD', 'TH', 'TC']
        ];

        $excepted = [
            [2, [4, 3, 10]],
            ['3S 3C 4D 4D TS']
        ];

        $this->assertEquals($excepted, (new Poker($hands))->getWinHands());
    }

    public function test_one_pair_bigger_high_card()
    {
        $hands = [
            ['AS', 'KC', 'QD', 'TH', 'TC'],
            ['3S', '5D', 'AC', 'TS', '2H']
        ];

        $excepted = [
            [1, [10, 14, 13, 12]],
            ['AS KC QD TH TC']
        ];

        $this->assertEquals($excepted, (new Poker($hands))->getWinHands());
    }

    public function test_high_car_bigger_another()
    {
        $hands = [
            ['3S', '6D', 'AC', 'TS', '2H'],
            ['AD', 'TC', '5S', '4S', '3H']
        ];

        $excepted = [
            [0, [14, 10, 6, 3, 2]],
            ['3S 6D AC TS 2H']
        ];

        $this->assertEquals($excepted, (new Poker($hands))->getWinHands());
    }

    public function test_multiple_high_car_equals()
    {
        $hands = [
            ['AD', 'TC', '5S', '4S', '3H'],
            ['3S', '6D', '9C', 'TS', '2H'],
            ['AS', 'TH', '5C', '4H', '3C']
        ];

        $excepted = [
            [0, [14, 10, 5, 4, 3]],
            [
                'AD TC 5S 4S 3H',
                'AS TH 5C 4H 3C'
            ],
        ];

        $this->assertEquals($excepted, (new Poker($hands))->getWinHands());
    }

    public function test_all_permutations_staight_flush_biggest()
    {
        $hands = [
            ['2D', 'AD', '3D', '4D', '5D'],
            ['2S', '2H', '2D', '3C', '3H'],
            ['AS', '2H', '3D', '4C', '5H'],
            ['AS', 'AH', '3D', 'AC', 'AD'],
            ['AS', 'AH', '3D', 'AC', 'AD'],
            ['2D', '2H', '3C', '3S', '3D'],
            ['3S', '6S', '6S', '8S', 'KS'],
            ['2H', '3H', '4S', '5S', '6C'],
            ['2S', '2D', '2C', 'AD', '7S'],
            ['3S', '3C', '4D', '4D', 'TS'],
            ['AS', 'KC', 'QD', 'TH', 'TC'],
            ['3S', '5D', 'AC', 'TS', '2H'],
            ['2S', '2D', '2C', 'AD', '7S'],
            ['3S', '3C', '4D', '4D', 'TS']
        ];

        $excepted = [
            [8, [5]],
            ['2D AD 3D 4D 5D']
        ];

        $this->assertEquals($excepted, (new Poker($hands))->getWinHands());
    }

    public function test_some_random_case()
    {
        foreach (range(0, 1000) as $i) {
            $hands[] = (new RandomGenerator)->generateHand();
        }

        $hands[] = ['KS', 'AS', 'QS', 'JS', 'TS'];

        $excepted = [
            [8, [14]],
            ['KS AS QS JS TS']
        ];

        $this->assertEquals($excepted, (new Poker($hands))->getWinHands());
    }
}
