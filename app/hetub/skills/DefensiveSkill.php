<?php
namespace hetub\skills;

abstract class DefensiveSkill extends Skill {
    public abstract function enhanceDefence($damage);
}