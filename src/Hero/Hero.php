<?php

namespace VaneaVasco\Hetub\Hero;

use VaneaVasco\Hetub\Emitter\Emitter;
use VaneaVasco\Hetub\Skill\Skill;

abstract class Hero
{
    private $skills;
    private $properties;
    protected $isAlive;
    /**
     * @var Emitter
     */
    protected $emitter;

    public function __construct(Emitter $emitter)
    {
        $this->skills     = [];
        $this->properties = [];
        $this->isAlive    = true;
        $this->emitter    = $emitter;
    }

    public function attack()
    {
        $primaryDamage = $this->properties['strength'];
        if (isset($this->skills['attack'])) {
            foreach ($this->skills['attack'] as $attackSkill) {
                $primaryDamage = $attackSkill->enhanceAttack($primaryDamage);
            }
        }
        $this->emitter->emit('hero.event', $this->properties['name'] . ' attacks with ' . $primaryDamage . ' damage.');

        return $primaryDamage;
    }

    public function defend($attackDamage)
    {
        if ($this->properties['luck'] >= rand(1, 100)) {
            $this->emitter->emit('hero.event', $this->properties['name'] . ' used evasion! No damage done! ');

            return;
        }
        $attackDamage -= $this->properties['defence'];

        if (isset($this->skills['defence'])) {
            foreach ($this->skills['defence'] as $defence) {
                $attackDamage = $defence->enhanceDefence($attackDamage);
            }
        }
        $this->emitter->emit('hero.event', $this->properties['name'] . ' takes ' . $attackDamage . ' damage.');
        $this->properties['health'] -= $attackDamage;

        if ($this->properties['health'] <= 0) {
            $this->isAlive = false;
            $this->emitter->emit('hero.event', $this->properties['name'] . ' died!');
        }
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }
    }

    public function __set($name, $value)
    {
        $this->properties[$name] = $value;
    }

    public function addSkill($skillType, Skill $newSkill)
    {
        $this->skills[$skillType][] = $newSkill;
    }

    public function isAlive()
    {
        return $this->isAlive;
    }

    public function getDisplayProperties()
    {
        $returnString = '';
        foreach ($this->properties as $propertyName => $propertyValue) {
            $returnString .= sprintf(" %s: %3s |", $propertyName, $propertyValue);
        }

        return rtrim($returnString, '| ');
    }
}