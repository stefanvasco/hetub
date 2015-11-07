<?php
namespace hetub\mechanics;

class Game {
    private $turnManager;
    private $players;
    private $gameEnd;

    public function __construct(array $players, TurnManager $turnManager, GameEnd $gameEnd)
    {
        $this->players = $players;
        $this->turnManager = $turnManager;
        $this->gameEnd = $gameEnd;
    }

    public function initGame()
    {
        $this->turnManager->init($this->players);
        $this->turnManager->registerTurnListener($this->gameEnd);
    }

    public function run()
    {
        while(!$this->gameEnd->finishedGame()) {
            $attackerIndex = $this->turnManager->getCurrentPlayer();
            $defenderIndex = $this->turnManager->getRandomDefender();
            $attacker = $this->players[$attackerIndex];
            $defender = $this->players[$defenderIndex];
            $defender->defend($attacker->attack());
            if(!$defender->isAlive()) {
                $this->turnManager->removePlayer($defenderIndex);
                $this->gameEnd->playerEliminated();
            }
            $this->turnManager->finishPlayerTurn();

            if($this->turnManager->turnIsFinished()) {
                $this->turnManager->startTurn();
            }
        }
    }
}