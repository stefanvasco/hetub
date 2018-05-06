<?php

namespace VaneaVasco\Hetub\Skills;

abstract class AttackSkill extends Skill
{
    public abstract function enhanceAttack($damage);
}
