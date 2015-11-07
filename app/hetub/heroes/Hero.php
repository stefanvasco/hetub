<?php
namespace hetub\heroes;

abstract class Hero
{
    private $skills;
    private $properties;

    public function __construct()
    {
        $this->skills = array();
        $this->properties = array();
    }

    public abstract function attack();

    public abstract function defend();

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
}