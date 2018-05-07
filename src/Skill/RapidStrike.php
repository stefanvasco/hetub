<?php

namespace VaneaVasco\Hetub\Skill;

class RapidStrike extends AttackSkill
{
    public function enhanceAttack($damage)
    {
        if (rand(1, 100) <= $this->probability) {
            $damage *= $this->factor;
            $this->emitter->emit('skill.event', 'Rapid Strike skill is used!');
        }

        return $damage;
    }
}
