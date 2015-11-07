<?php
namespace hetub\mechanics;

class GameEnd
{
    const MAX_TURNS = 20;
    protected $finished;
    protected $playersCount;

    public function __construct()
    {
        $this->finished = false;
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
        $this->finished = static::MAX_TURNS <= $turnCount ? true : false;
    }

    public function playerEliminated()
    {
        $this->finished = --$this->playersCount <= 1 ? true : false;
    }

    public function finishedGame()
    {
        return $this->finished;
    }


}