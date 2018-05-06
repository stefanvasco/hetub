<?php

namespace VaneaVasco\Hetub\Skill\Factory;

use VaneaVasco\Hetub\Skill\Skill;
use VaneaVasco\Hetub\Skill\AttackSkill;
use VaneaVasco\Hetub\Skill\MagicShield;
use VaneaVasco\Hetub\Skill\RapidStrike;
use VaneaVasco\Hetub\Skill\DefensiveSkill;


class SkillFactory
{
    const SKILL_NAMESPACE = 'VaneaVasco\\Hetub\\Skill\\';

    /**
     * @param array $properties
     *
     * @return Skill[]
     */
    public function createSkills($properties)
    {
        $skills = [];
        if (isset($properties['skills'])) {
            foreach ($properties['skills'] as $skillName => $skill) {
                $fullSkillName = static::SKILL_NAMESPACE . $skillName;
                if (class_exists($fullSkillName)) {
                    $skillObject        = new $fullSkillName($skill['factor'], $skill['probability']);
                    $skills[$skillName] = $skillObject;
                }
            }
        }

        return $skills;
    }
}