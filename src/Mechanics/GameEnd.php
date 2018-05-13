<?php

namespace VaneaVasco\Hetub\Mechanics;

class GameEnd
{
    const MAX_TURNS = 20;
    protected $finished;
    protected $playersCount;

    public function __construct()
    {
        $this->finished     = false;
        $this->playersCount = 0;
    }

    public function setPlayersCount($playersCount)
    {
        $this->playersCount = $playersCount;
    }

    public function addPlayer()
    {
        $this->playersCount++;
    }

    public function turnEnded($turnCount)
    {
        $this->finished = static::MAX_TURNS <= $turnCount ? true : $this->finished;
    }

    public function playerEliminated()
    {
        $this->playersCount--;
        $this->finished = $this->playersCount <= 1 ? true : $this->finished;
    }

    public function finishedGame()
    {
        return $this->finished;
    }
}
