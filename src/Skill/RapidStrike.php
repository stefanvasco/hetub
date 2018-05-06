<?php

namespace VaneaVasco\Hetub\Skill;

use VaneaVasco\Hetub\Display\Message as Message;

class RapidStrike extends AttackSkill
{
    public function enhanceAttack($damage)
    {
        if (rand(1, 100) <= $this->probability) {
            $damage *= $this->factor;
            Message::display('Rapid Strike skill is used!');
        }

        return $damage;
    }
}
