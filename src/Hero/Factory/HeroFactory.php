<?php

namespace VaneaVasco\Hetub\Hero\Factory;

use VaneaVasco\Hetub\Emitter\Emitter;
use VaneaVasco\Hetub\Hero\Hero;
use VaneaVasco\Hetub\Skill\Skill;

class HeroFactory
{
    const HERO_NAMESPACE = 'VaneaVasco\\Hetub\\Hero\\';

    /**
     * @param string $heroType
     * @param string $heroName
     * @param array $properties
     *
     * @param Skill[] $skills
     *
     * @return mixed
     */
    public function create($heroType, $heroName, array $properties, array $skills)
    {
        if (!class_exists(self::HERO_NAMESPACE . $heroType)) {
            throw new \InvalidArgumentException('Invalid hero type ' . $heroType);
        }

        $heroType = self::HERO_NAMESPACE . $heroType;
        $emitter  = Emitter::getInstance();
        $hero     = new $heroType($emitter);
        $this->setSkills($hero, $skills);
        $this->setProperties($properties, $hero);
        $hero->name = $heroName;

        return $hero;
    }

    /**
     * @param Hero $hero
     * @param Skill[] $skills
     */
    protected function setSkills(Hero $hero, $skills)
    {
        foreach ($skills as $skillType => $skill) {
            $hero->addSkill($skillType, $skill);
        }
    }

    /**
     * @param $properties
     * @param $hero
     */
    protected function setProperties($properties, $hero)
    {
        foreach ($properties as $name => $value) {
            $hero->$name = rand($value['min'], $value['max']);
        }
    }
}
