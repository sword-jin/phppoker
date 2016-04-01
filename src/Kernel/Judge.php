<?php

namespace Poker\Kernel;

class Judge
{
    /**
     * @array
     */
    protected static $GRADES = [
        'High card, i am so luck',
        'One pair, dangerous',
        'Two pair, just soso',
        'Three of a kind, oh year!',
        'Ok, Straight, not bad',
        'Flush is nice',
        'Who can? Full house!!!',
        'HAHA, Cool, Four of a kind',
        'Oh, gad, Straight flush',
    ];

    /**
     * @var array
     */
    protected $hands;

    /**
     * @var array
     */
    protected $players;

    /**
     * @param array $hands
     * @param array $players
     */
    public function __construct($hands, $players)
    {
        $this->hands = $hands;
        $this->players = $players;
    }

    /**
     * Get all max result.
     *
     * @return array
     */
    public function getAllMax()
    {
        $results = (new Poker($this->hands))->getWinHands();
        $grade = self::$GRADES[$results[0][0]];
        $winner[] = $grade;

        foreach ($results[1] as $hand) {
            foreach ($this->players as $cards) {
                if ($hand == $cards[1]) {
                    $winner[1][] = $cards[0];
                }
            }
        }

        return $winner;
    }
}
