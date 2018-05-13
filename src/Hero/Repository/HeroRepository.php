<?php

namespace VaneaVasco\Hetub\Hero\Repository;

use VaneaVasco\Hetub\Hero\Factory\HeroFactory;
use VaneaVasco\Hetub\Hero\Gateway\HeroJSON;
use VaneaVasco\Hetub\Skill\Factory\SkillFactory;
use VaneaVasco\Hetub\Hero\Gateway\Hero as HeroGateway;

class HeroRepository
{
    /** @var HeroFactory */
    protected $heroFactory;
    /**
     * @var SkillFactory
     */
    private $skillFactory;
    /**
     * @var HeroGateway
     */
    private $heroGateway;

    public function __construct(HeroFactory $heroFactory, SkillFactory $skillFactory, HeroGateway $heroGateway)
    {
        $this->heroFactory  = $heroFactory;
        $this->skillFactory = $skillFactory;
        $this->heroGateway  = $heroGateway;
    }

    public function getHero($heroType, $heroName)
    {
        try {
            $profileData = $this->heroGateway->getHeroProfile($heroType);
            $skills      = $this->skillFactory->createSkills($profileData);
            unset($profileData['skills']);
            $heroModel = $this->heroFactory->create($heroType, $heroName, $profileData, $skills);

            return $heroModel;
        } catch (\Exception $exception) {
            throw new \Exception('Could not get hero ' . $heroType);
        }
    }
}
