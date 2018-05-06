<?php

namespace VaneaVasco\Hetub\Mechanics;

use VaneaVasco\Hetub\Display\Message;
use VaneaVasco\Hetub\Emitter\Emitter;
use VaneaVasco\Hetub\Hero\Hero;

/**
 * Class Game
 * @package VaneaVasco\Hetub\Mechanics
 */
class Game
{
    /**
     * @var TurnManager
     */
    private $turnManager;
    /**
     * @var Hero[]
     */
    private $players;
    /**
     * @var GameEnd
     */
    private $gameEnd;

    /**
     * @var Emitter
     */
    private $emitter;

    /**
     * Game constructor.
     *
     * @param array $players
     * @param TurnManager $turnManager
     * @param GameEnd $gameEnd
     * @param Emitter $emitter
     */
    public function __construct(array $players, TurnManager $turnManager, GameEnd $gameEnd, Emitter $emitter)
    {
        $this->players     = $players;
        $this->turnManager = $turnManager;
        $this->gameEnd     = $gameEnd;
        $this->emitter     = $emitter;
    }

    /**
     *
     */
    public function initGame()
    {
        $this->gameEnd->setPlayersCount(count($this->players));
        $this->turnManager->init($this->players);
        $this->turnManager->registerTurnListener($this->gameEnd);
    }

    /**
     *
     */
    public function run()
    {
        $this->emitter->emit('game.start', 'The fight begins.');
        while (!$this->gameEnd->finishedGame()) {
            $this->displayStats();
            $attackerIndex = $this->turnManager->getCurrentPlayer();
            $defenderIndex = $this->turnManager->getRandomDefender();
            $attacker      = $this->players[$attackerIndex];
            $defender      = $this->players[$defenderIndex];
            $defender->defend($attacker->attack());
            if (!$defender->isAlive()) {
                $this->turnManager->removePlayer($defenderIndex);
                $this->gameEnd->playerEliminated();
            }
            $this->turnManager->finishPlayerTurn();

            if ($this->turnManager->turnIsFinished() && !$this->gameEnd->finishedGame()) {
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
        $this->emitter->emit('game.won', $theWinnerIs->name . ' WON!');
    }

    /**
     *
     */
    public function displayStats()
    {
        foreach ($this->players as $player) {
            $this->emitter->emit('game.stats', $player->getDisplayProperties());
        }
    }
}
