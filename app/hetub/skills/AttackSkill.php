<?php
namespace hetub\skills;

abstract class AttackSkill extends Skill{
    public abstract function enhanceAttack($damage);
}