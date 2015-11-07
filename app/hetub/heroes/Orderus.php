<?php
namespace hetub\heroes;


class Orderus extends Hero{

    public function attack()
    {
        return parent::attack();
    }

    public function defend($damage)
    {
        return parent::defend($damage);
    }
}