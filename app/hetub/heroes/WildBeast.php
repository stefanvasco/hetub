<?php
namespace hetub\heroes;

class WildBeast extends Hero{

    public function attack()
    {
        return parent::attack();
    }

    public function defend($damage)
    {
        return parent::defend($damage);
    }
}