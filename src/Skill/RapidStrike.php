<?php

namespace VaneaVasco\Hetub\Skill;

/**
 * Class RapidStrike
 * @package VaneaVasco\Hetub\Skill
 */
class RapidStrike extends AttackSkill
{
    /**
     * @param $damage
     *
     * @return int
     */
    public function enhanceAttack($damage)
    {
        if ($this->getRand() <= $this->probability) {
            $damage *= $this->factor;
            $this->emitter->emit('skill.event', 'Rapid Strike skill is used!');
        }

        return $damage;
    }

    /**
     * @return int
     */
    protected function getRand(): int
    {
        return rand(1, 100);
    }
}
