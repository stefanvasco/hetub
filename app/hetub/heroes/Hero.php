<?php
namespace hetub\heroes;

use hetub\display\Message;

abstract class Hero
{
    private $skills;
    private $properties;
    protected $isAlive;

    public function __construct()
    {
        $this->skills = array();
        $this->properties = array();
        $this->isAlive = true;
    }

    public function attack()
    {
        $primaryDamage = $this->properties['strength'];
        if(isset($this->skills['attack'])) {
            foreach ($this->skills['attack'] as $attackSkill) {
                $primaryDamage = $attackSkill->enhanceAttack($primaryDamage);
            }
        }
        Message::display($this->properties['name'] .' attacks with ' . $primaryDamage . ' damage.');
        return $primaryDamage;
    }

    public function defend($attackDamage)
    {
        if($this->properties['luck'] >= rand(1,100)) {
            Message::display($this->properties['name'].' used evasion! No damage done! ');
            return;
        }
        if(isset($this->skills['defence'])) {
            foreach ($this->skills['defence'] as $defence) {
                $attackDamage = $defence->enhanceDefence($attackDamage);
            }
        }
        Message::display($this->properties['name'] .' takes ' . $attackDamage . ' damage.');
        $this->properties['health']-= $attackDamage;

        if($this->properties['health']<=0) {
            $this->isAlive = false;
            Message::display($this->properties['name'] .' died!');
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

    public function addSkill($skillType, $newSkill)
    {
        $this->skills[$skillType][] = $newSkill;
    }

    public function isAlive(){
        return $this->isAlive;
    }

    public function getDisplayProperties()
    {
        $returnString = '';
        foreach($this->properties as $propertyName => $propertyValue) {
            $returnString .= "$propertyName:$propertyValue | ";
        }
        return rtrim($returnString,'| ');
    }
}