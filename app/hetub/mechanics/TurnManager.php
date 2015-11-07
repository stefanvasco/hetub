<?php
namespace hetub\mechanics;

class TurnManager
{
    protected $players;
    protected $turnCount;
    protected $turnOrder;
    protected $roles;
    protected $currentPlayer;
    protected $turnIsFinished;
    protected $turnListeners;

    public function __construct()
    {
        $this->turnListeners = array();
    }

    public function init($players)
    {
        $this->players = $players;
        $this->getInitialTurnOrder();
        $this->setInitialRoles();
        $this->currentPlayer = 0;
    }

    protected function getInitialTurnOrder()
    {
        uasort($this->players, function ($playerA, $playerB) {
            if ($playerA->speed == $playerB->speed) {
                if ($playerA->luck == $playerB->luck) {
                    return 0;
                } elseif ($playerA->luck > $playerB->luck) {
                    return -1;
                } else {
                    return 1;
                }
            }
            return $playerA->speed > $playerB->speed ? -1 : 1;
        });
        $this->turnOrder = array_keys($this->players);
    }

    protected function setInitialRoles()
    {
        $this->roles = array_fill_keys($this->turnOrder, false);
        $this->roles[current(array_keys($this->roles))] = true;
    }

    protected function changeRoles()
    {
        array_walk($this->roles, function (&$val) {
            $val = !$val;
        });
    }

    protected function computeCurrentTurnOrder()
    {
        $roles = $this->roles;
        uasort($this->turnOrder, function ($playerA, $playerB) use ($roles) {
            if ($roles[$playerA] == $roles[$playerB]) {
                return 0;
            }
            return $roles[$playerA] >= $roles[$playerB] ? -1 : 1;
        });
    }

    public function removePlayer($playerKey)
    {
        $orderKey = array_search($playerKey, $this->turnOrder);
        if ($orderKey) {
            unset($this->turnOrder[$orderKey]);
        }

        if (array_keys($this->roles, $playerKey)) {
            unset($this->roles[$playerKey]);
        }
    }

    public function getCurrentPlayer()
    {
        return $this->turnOrder[$this->currentPlayer];
    }

    public function getRandomDefender()
    {
        $currentPlayer = $this->currentPlayer;
        $defenders = array_filter($this->roles, function ($isAttacker) use ($currentPlayer) {
            return !$isAttacker;
        });
        return array_rand($defenders);
    }

    public function startTurn()
    {
        $this->changeRoles();
        $this->computeCurrentTurnOrder();
        $this->currentPlayer = 0;
        $this->turnIsFinished = false;
    }

    public function finishPlayerTurn()
    {
        $proposedNextPlayer = $this->currentPlayer + 1;
        if (array_key_exists($proposedNextPlayer, $this->turnOrder)) {
            $this->currentPlayer = $proposedNextPlayer;
            $this->changeRoles();
        } else {
            $this->turnIsFinished = true;
            $this->turnCount++;
            $this->notifyTurnListeners();
        }
    }

    public function turnIsFinished()
    {
        return $this->turnIsFinished;
    }

    public function registerTurnListener(&$turnListener)
    {
        array_push($this->turnListeners, $turnListener);
    }

    private function notifyTurnListeners()
    {
        foreach ($this->turnListeners as $turnListener) {
            $turnListener->turnEnded($this->turnCount);
        }
    }
}