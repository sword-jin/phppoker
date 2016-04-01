<?php

namespace Poker\Kernel;

use Poker\Tools\Transfer;
use InvalidArgumentException;

class HandHandler
{
    /**
     * HandHandler singleton
     *
     * @var self
     */
    protected static $handler;

    /**
     * The poker index.
     *
     * @var string
     */
    protected $orders = '--23456789TJQKA';

    /**
     * Get the handhandle instance.
     *
     * @return self
     */
    public static function getIns()
    {
        if (! isset(static::$handler)) {
            static::$handler = new self;
        }

        return static::$handler;
    }

    /**
     * Assign a hand a category.
     *
     * @param  array $hand
     *
     * @return array
     */
    public function assignCategory($hand)
    {
        list($ranks, $times, $origin) = $this->getRanksAndTimesByHand($hand);

        $staright = $this->isStaright($ranks);
        $flush = $this->isFlush($hand);

        if ($staright && $flush) {
            return [8, [$ranks[0]]];
        } elseif ($this->isFourOfKind($times)) {
            return [7, $ranks];
        } elseif ($this->isFullHouse($times)) {
            return [6, $ranks];
        } elseif ($flush) {
            return [5, $origin];
        } elseif ($staright) {
            return [4, [$ranks[0]]];
        } elseif ($this->isThreeOfKind($times)) {
            return [3, $ranks];
        } elseif ($this->isTwoPair($times)) {
            return [2, $ranks];
        } elseif ($this->isOnePair($times)) {
            return [1, $ranks];
        } else {
            return [0, $ranks];
        }
    }

    /**
     * Compare two group of hand.
     *
     * @param  array  $a
     * @param  array  $b
     *
     * @return boolean
     */
    public function bigger(array $a, array $b)
    {
        if ($a[0] > $b[0]) {
            return true;
        } elseif ($a[0]== $b[0]) {
            $transfer = Transfer::getIns();
            $number1 = $transfer->toNumber($a[1]);
            $number2 = $transfer->toNumber($b[1]);

            return $number1 > $number2;
        } else {
            return false;
        }
    }

    /**
     * Get the poker ranks and every rank times.
     *
     * @return array
     */
    public function getRanksAndTimesByHand($hand)
    {
        if (count($hand) < 5) {
            throw new InvalidArgumentException("Hand must have 5 or 5+ pokers");
        }

        $ranks = map($hand, function($card) {
            return strpos($this->orders, $card[0]);
        });

        list($ranks, $times, $origin) = groupBy($ranks);

        if ($ranks == [14, 5, 4, 3, 2]) {
            $ranks = [5, 4, 3, 2, 1];
        }

        return [$ranks, $times, $origin];
    }

    /**
     * Get the rank by a group hand.
     *
     * @param  array $hand
     *
     * @return array
     */
    public function getRanksByHand($hand)
    {
        return $this->getRanksAndTimesByHand($hand)[0];
    }

    /**
     * Determinate a rank whether staright.
     *
     * @param  array  $rank
     *
     * @return boolean
     */
    public function isStaright($rank)
    {
        return count($rank) == 5 && (max($rank) - min($rank)) == 4;
    }

    /**
     * Determinate a rank whether flush.
     *
     * @param  array $hand
     *
     * @return boolean
     */
    public function isFlush($hand)
    {
        $suits = map($hand, function($card) {
            return $card[1];
        });

        return count(array_flip($suits)) == 1;
    }

    /**
     * Determinate a rank whether four of kind.
     *
     * @param  array  $times
     *
     * @return boolean
     */
    public function isFourOfKind($times)
    {
        return $times == [4, 1];
    }

    /**
     * Determinate a rank whether full house.
     *
     * @param  array  $times
     *
     * @return boolean
     */
    public function isFullHouse($times)
    {
        return $times == [3, 2];
    }

    /**
     * Determinate a rank whether three of kind.
     *
     * @param  array  $times
     *
     * @return boolean
     */
    public function isThreeOfKind($times)
    {
        return $times == [3, 1, 1];
    }

    /**
     * Determinate a rank whether two pair.
     *
     * @param  array  $times
     *
     * @return boolean
     */
    public function isTwoPair($times)
    {
        return $times == [2, 2, 1];
    }

    /**
     * Determinate a rank whether one pair.
     *
     * @param  array  $times
     *
     * @return boolean
     */
    public function isOnePair($times)
    {
        return $times == [2, 1, 1, 1];
    }
}
