<?php

namespace Poker\Tools;

class RandomGenerator
{
    protected $sentCards = [];

    /**
     * Generate a group hand.
     *
     * @return array
     */
    public function generateHand()
    {
        foreach(range(0, 4) as $i) {
            $cards[] = $this->getUniqueCard();
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

    public function getUniqueCard()
    {
        $card = (string)$this->randomRank() . 'SHDC'[mt_rand(0, 3)];

        if (in_array($card, $this->sentCards)) {
            return $this->getUniqueCard();
        }

        $this->sentCards[] = $card;

        return $card;
    }
}
