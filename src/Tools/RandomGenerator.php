<?php

namespace Poker\Tools;

class RandomGenerator
{
    /**
     * Generate a group hand.
     *
     * @return array
     */
    public function generateHand()
    {
        foreach(range(0, 4) as $i) {
            $cards[] = (string)$this->randomRank() . 'SHDC'[mt_rand(0, 3)];
        }

        return $cards;
    }

    /**
     * Generate a rank.
     *
     * @return string
     */
    protected function randomRank()
    {
        $ranks = ['2','3','4','5','6','7','8','9','T','J','Q','K','A'];

        return $ranks[mt_rand(0, 12)];
    }
}
