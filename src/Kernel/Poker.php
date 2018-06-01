<?php

namespace Poker\Kernel;

class Poker
{
    /**
     * The smallest hand.
     */
    protected static $SMALLEST = [0, ['5', '4', '3', '2', '1']];

    /**
     * All players hands poker.
     *
     * @var array
     */
    protected $hands;

    /**
     * All poker levels.
     *
     * @var array
     */
    protected $levels;

    /**
     * The winners description.
     *
     * @var array
     */
    protected $winHands;

    /**
     * The biggest poker level.
     *
     * @var array
     */
    protected $biggestLevel;

    /**
     * @var \Poker\Kernel\HandHandler
     */
    protected $rankHandler;

    /**
     * @param array $hands
     * @param \Poker\Kernel\HandHandler $rankHandler
     */
    public function __construct($hands)
    {
        $this->hands = $hands;

        $this->rankHandler = HandHandler::getIns();
    }

    /**
     * Get thw biggest hands.
     *
     * @return array
     */
    public function getWinHands()
    {
        $this->getRanks()
            ->getAllCardLevels()
            ->handlerLevels();

        return [
            $this->biggestLevel,
            $this->winHands[$this->levelToString($this->biggestLevel)]
        ];
    }

    /**
     * Handler all levels.
     */
    protected function handlerLevels()
    {
        $this->biggestLevel = self::$SMALLEST;

        foreach ($this->levels as $hand => $level) {
            if (! $this->rankHandler->bigger($this->biggestLevel, $level)) {
                $this->winHands[$this->levelToString($level)][] = $hand;
                $this->biggestLevel = $level;
            }
        }
    }

    /**
     * Get all card levels.
     *
     * @return self
     */
    protected function getAllCardLevels()
    {
        foreach ($this->hands as $hand) {
            $this->levels[implode(' ', $hand)] = $this->rankHandler->assignCategory($hand);
        }

        return $this;
    }

    /**
     * Get all hands ranks.
     *
     * @return self
     */
    protected function getRanks()
    {
        foreach ($this->hands as $hand) {
            $this->ranks[] = $this->rankHandler->getRanksByHand($hand);
        }

        return $this;
    }

    /**
     * Transfer level to string.
     *
     * @param  array $level
     *
     * @return string
     */
    public function levelToString($level)
    {
        return $level[0] . '-' . implode('', $level[1]);
    }
}
