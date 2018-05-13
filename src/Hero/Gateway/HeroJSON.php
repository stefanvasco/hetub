<?php

namespace VaneaVasco\Hetub\Hero\Gateway;

/**
 * Class HeroJSON
 * @package VaneaVasco\Hetub\Hero\Gateway
 */
class HeroJSON implements Hero
{
    /**
     * @var string
     */
    protected $dataFolder;

    /**
     * HeroJSON constructor.
     *
     * @param string $dataFolder
     */
    public function __construct($dataFolder)
    {
        $this->dataFolder = $dataFolder;
    }

    /**
     * @param $heroType
     *
     * @return mixed
     */
    public function getHeroProfile($heroType)
    {
        if (!file_exists($this->dataFolder . strtolower($heroType))) {
            throw new \InvalidArgumentException('Invalid hero type ' . $heroType);
        }

        $heroProfile = json_decode(file_get_contents($this->dataFolder . strtolower($heroType)), true);
        if ($heroProfile === false) {
            throw new \InvalidArgumentException('Invalid hero stored profile ' . $heroType);
        }

        return $heroProfile;
    }
}