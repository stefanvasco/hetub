<?php
namespace hetub\mechanics;

use hetub\display\Message;

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
        $this->gameEnd->setPlayersCount(count($this->players));
        $this->turnManager->init($this->players);
        $this->turnManager->registerTurnListener($this->gameEnd);
    }

    public function run()
    {
        Message::display('The fight begins.');
        while(!$this->gameEnd->finishedGame()) {
            $this->displayStats();
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

            if($this->turnManager->turnIsFinished() && !$this->gameEnd->finishedGame()) {
                $this->turnManager->startTurn();
            }
            Message::display("\n");
        }

        uasort($this->players, function ($playerA, $playerB) {
            if ($playerA->health == $playerB->health) {
                if ($playerA->luck == $playerB->luck) {
                    return 0;
                }
                return $playerA->luck > $playerB->luck ? -1 : 1;
            }
            return $playerA->health < $playerB->health ? -1 : 1;
        });
        $theWinnerIs = array_pop($this->players);
        Message::display($theWinnerIs->name . ' WON!');
    }

    public function displayStats()
    {
        foreach($this->players as $player) {
            Message::display($player->getDisplayProperties());
        }
    }
}