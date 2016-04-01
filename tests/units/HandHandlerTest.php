<?php

use Poker\Kernel\HandHandler;

class HandHandlerTest extends PHPUnit_Framework_TestCase
{
    protected $handler;

    public function __construct()
    {
        $this->handler = HandHandler::getIns();
    }

    public function test_it_is_a_singleton()
    {
        $this->assertEquals($this->handler, HandHandler::getIns());
    }

    public function test_it_can_parse_a_poker_array_with_5_pokers()
    {
        $hand = ['2S', '2S', '2S', '3D', '3C'];

        $this->assertEquals([2, 3], $this->handler->getRanksByHand($hand));
    }

    public function test_poker_4_4_4_4_3()
    {
        $hand = ['4S', '4H', '4D', '4C', '3H'];

        $this->assertEquals([4, 3], $this->handler->getRanksByHand($hand));
    }

    public function test_poker_3_4_4_4_4()
    {
        $hand = ['3S', '4S', '4H', '4D', '4C'];

        $this->assertEquals([4, 3], $this->handler->getRanksByHand($hand));
    }

    public function test_poker_A_2_3_4_5()
    {
        $hand = ['AS', '4S', '4H', '4D', '4C'];

        $this->assertEquals([4, 14], $this->handler->getRanksByHand($hand));
    }

    public function test_poker_A_T_J_Q_K()
    {
        $hand = ['AS', 'TS', 'JH', 'QD', 'KC'];

        $this->assertEquals([14, 13, 12, 11, 10], $this->handler->getRanksByHand($hand));
    }

    public function test_2_3_8_9_K()
    {
        $hand = ['2S', '3S', '8H', '9D', 'KC'];

        $this->assertEquals([13, 9, 8, 3, 2], $this->handler->getRanksByHand($hand));
    }

    public function test_K_K_k_J_J()
    {
        $hand = ['KS', 'KS', 'KH', 'JD', 'JC'];

        $this->assertEquals([13, 11], $this->handler->getRanksByHand($hand));
    }

    public function test_it_throw_a_invalid_exception_when_parse_a_hasnd_with_a_poker()
    {
        $this->setExpectedException('InvalidArgumentException', 'Hand must have 5 or 5+ pokers');

        $hand = ['2S2H2D3C3H'];
        $rank = $this->handler->getRanksByHand($hand);
    }

    public function test_it_throw_a_invalid_argument_exception_when_parse_a_hand_with_three_poker()
    {
        $this->setExpectedException('InvalidArgumentException', 'Hand must have 5 or 5+ pokers');

        $hand = ['2S', '3H', '2D'];
        $rank = $this->handler->getRanksByHand($hand);
    }

    public function test_3_5_6_4_2_is_straight()
    {
        $hand = ['3D', '5D', '6D', '4D', '2D'];
        $rank = $this->handler->getRanksByHand($hand);

        $this->assertTrue($this->handler->isStaright($rank));
    }

    public function test_5_3_2_A_4_is_straight()
    {
        $hand = ['5D', '3D', '2D', 'AD', '4D'];
        $rank = $this->handler->getRanksByHand($hand);

        $this->assertTrue($this->handler->isStaright($rank));
    }

    public function test_T_J_Q_K_A_is_straight()
    {
        $hand = ['TD', 'JD', 'QD', 'KD', 'AD'];
        $rank = $this->handler->getRanksByHand($hand);

        $this->assertTrue($this->handler->isStaright($rank));
    }

    public function test_3_8_3_3_2_is_not_staright()
    {
        $rank = ['3', '8', '3', '3', '2'];

        $this->assertFalse($this->handler->isStaright($rank));
    }

    public function test_one_suits_is_flush()
    {
        $hand = ['3D', 'AD', 'AD', '3D', '2D'];

        $this->assertTrue($this->handler->isFlush($hand));
    }

    public function test_it_not_flush_one_more_suites()
    {
        $hand = ['3D', 'AD', '3D', '3H', '2D'];

        $this->assertFalse($this->handler->isFlush($hand));
    }

    public function test_is_straight_and_flush()
    {
        $hand = ['2D', 'AD', '3D', '4H', '5D'];
        $rank = $this->handler->getRanksByHand($hand);

        $this->assertTrue($this->handler->isStaright($rank));
        $this->assertFalse($this->handler->isFlush($hand));
    }

    public function test_3_3_3_3_2_is_four_of_kind()
    {
        $hand = ['2D', '3D', '3D', '3H', '3D'];
        $times = $this->handler->getRanksAndTimesByHand($hand)[1];

        $this->assertTrue($this->handler->isFourOfKind($times));
    }

    public function test_3_3_3_2_2_is_full_house()
    {
        $hand = ['2D', '3D', '2D', '3H', '2D'];
        $times = $this->handler->getRanksAndTimesByHand($hand)[1];

        $this->assertTrue($this->handler->isFullHouse($times));
    }

    public function test_3_3_3_A_2_is_three_of_kind()
    {
        $hand = ['AD', '3D', '3D', '3H', '2D'];
        $times = $this->handler->getRanksAndTimesByHand($hand)[1];

        $this->assertTrue($this->handler->isThreeOfKind($times));
    }

    public function test_T_T_J_Q_J_is_two_pair()
    {
        $hand = ['TD', 'TD', 'JD', 'QH', 'JD'];
        $times = $this->handler->getRanksAndTimesByHand($hand)[1];

        $this->assertTrue($this->handler->isTwoPair($times));
    }

    public function test_T_T_K_Q_J_is_one_pair()
    {
        $hand = ['TD', 'TD', 'KD', 'QH', 'JD'];
        $times = $this->handler->getRanksAndTimesByHand($hand)[1];

        $this->assertTrue($this->handler->isOnePair($times));
    }

    public function test_assign_category_1()
    {
        $hand = ['AD', 'KD', 'QD', 'JD', 'TD'];
        $excepted = [8, [14]];

        $this->assertEquals($excepted, $this->handler->assignCategory($hand));
    }

    public function test_assign_category_2()
    {
        $hand = ['AD', 'AD', 'AD', 'KD', 'AH'];
        $excepted = [7, [14, 13]];

        $this->assertEquals($excepted, $this->handler->assignCategory($hand));
    }

    public function test_assign_category_3()
    {
        $hand = ['AD', 'AD', 'AD', 'KD', 'KH'];
        $excepted = [6, [14, 13]];

        $this->assertEquals($excepted, $this->handler->assignCategory($hand));
    }

    public function test_assign_category_4()
    {
        $hand = ['AD', 'TD', 'AD', 'KD', 'KD'];
        $excepted = [5, [14, 14, 13, 13, 10]];

        $this->assertEquals($excepted, $this->handler->assignCategory($hand));
    }

    public function test_assign_category_5()
    {
        $hand = ['AD', 'TH', 'QD', 'KD', 'JD'];
        $excepted = [4, [14]];

        $this->assertEquals($excepted, $this->handler->assignCategory($hand));
    }

    public function test_bigger_function_1()
    {
        $a = [8, [5, 4, 3, 2, 1]];
        $b = [8, [6, 5, 4, 3, 2]];

        $this->assertTrue($this->handler->bigger($b, $a));
    }

    public function test_bigger_function_2()
    {
        $a = [8, [5, 4, 3, 2, 1]];
        $b = [8, [5, 4, 3, 2, 1]];

        $this->assertFalse($this->handler->bigger($a, $b));
    }

    public function test_bigger_function_3()
    {
        $a = [8, [5, 4, 3, 2, 1]];
        $b = [4, [5, 4, 3, 2, 1]];

        $this->assertTrue($this->handler->bigger($a, $b));
    }

    public function test_bigger_function_4()
    {
        $a = [8, [1, 5, 4, 3, 2]];
        $b = [8, [6, 5, 4, 3, 2]];

        $this->assertFalse($this->handler->bigger($a, $b));
    }

    public function test_bigger_function_5()
    {
        $a = [8, ['A', 'K', 'Q', 'J', 'T']];
        $b = [8, ['K', 'Q', 'J', 'T', 9]];

        $this->assertTrue($this->handler->bigger($a, $b));
    }
}
