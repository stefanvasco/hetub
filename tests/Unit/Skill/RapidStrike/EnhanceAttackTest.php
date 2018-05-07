<?php

namespace Unit\Skill\RapidStrike;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use VaneaVasco\Hetub\Emitter\Emitter;
use VaneaVasco\Hetub\Skill\RapidStrike;

class EnhanceAttackTest extends TestCase
{
    /** @var  MockObject */
    protected $emitter;

    public function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        $this->emitter = $this->getMockBuilder(Emitter::class)
                              ->disableOriginalConstructor()
                              ->getMock();
    }

    /**
     * when enhanced attack is applied
     *
     * @dataProvider enhancedAttackProvider
     *
     * @param $factor
     * @param $probability
     * @param $rand
     * @param $defaultAttack
     * @param $enhancedAttack
     */
    public function testWhenEnhancedAttackIsApplied($factor, $probability, $rand, $defaultAttack, $enhancedAttack)
    {
        $this->emitter->expects($this->once())
                      ->method('emit')
                      ->with('skill.event', 'Rapid Strike skill is used!');

        $rapidStrike = $this->getMockBuilder(RapidStrike::class)
                            ->setMethods(['getRand'])
                            ->setConstructorArgs([$factor, $probability, $this->emitter])
                            ->getMock();

        $rapidStrike->method('getRand')
                    ->willReturn($rand);

        $enhancedAttackValue = $rapidStrike->enhanceAttack($defaultAttack);
        $this->assertEquals($enhancedAttack, $enhancedAttackValue);
    }

    public function enhancedAttackProvider()
    {
        return [
            'a valid enhanced attack' => [
                'factor'        => 2,
                'probability'   => 10,
                'rand'          => 9,
                'defaultAttack' => 10,
                'enhancedValue' => 20
            ],
        ];
    }
}
