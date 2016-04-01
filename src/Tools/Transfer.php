<?php

namespace Poker\Tools;

class Transfer
{
    /**
     * QUEUE card.
     */
    protected static $QUEUE = ['T', 'J', 'Q', 'K', 'A'];

    /**
     * QUEUE Values
     */
    protected static $NUMBER = ['10', '11', '12', '13', '14'];

    /**
     * SUITS
     */
    protected static $SUITS = ['S', 'H', 'C', 'D', 'T'];

    /**
     * FLOWERS
     */
    protected static $FLOWERS = ['♠', '♥', '♣', '♦', '10'];

    /**
     * Transfer self.
     *
     * @var self
     */
    protected static $transfer;

    /**
     * Get the Transfer singleton
     *
     * @return self
     */
    public static function getIns()
    {
        if (! isset(static::$transfer)) {
            static::$transfer = new self;
        }

        return static::$transfer;
    }

    /**
     * Transfer a rank to number.
     *
     * @param  $array $array
     *
     * @return string
     */
    public function toNumber($array)
    {
        $string = implode('', $array);

        return (int) str_replace(self::$QUEUE, self::$NUMBER, $string);
    }

    /**
     * Change suits to flowers.
     *
     * @param  array $hand
     *
     * @return string
     */
    public function toFlowers($hand)
    {
        return str_replace(self::$SUITS, self::$FLOWERS, $hand);
    }
}
