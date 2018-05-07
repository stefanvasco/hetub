<?php

namespace VaneaVasco\Hetub\Skill;

class MagicShield extends DefensiveSkill
{

    public function enhanceDefence($damage)
    {
        if (rand(1, 100) <= $this->probability) {
            $damage *= $this->factor;
            $this->emitter->emit('skill.event', 'Magic Shield skill is used!');
        }

        return $damage;
    }
}
