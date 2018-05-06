<?php

namespace VaneaVasco\Hetub\Hero\Gateway;

interface Hero
{
    /**
     * @param string $heroType
     *
     * @return mixed
     */
    public function getHeroProfile($heroType);
}
