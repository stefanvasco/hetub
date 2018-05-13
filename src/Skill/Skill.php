<?php

namespace VaneaVasco\Hetub\Skill;

use VaneaVasco\Hetub\Emitter\Emitter;

/**
 * Class Skill
 * @package VaneaVasco\Hetub\Skill
 */
abstract class Skill
{
    /**
     * @var
     */
    protected $factor;
    /**
     * @var
     */
    protected $probability;
    /**
     * @var Emitter
     */
    protected $emitter;

    /**
     * Skill constructor.
     *
     * @param int $factor
     * @param int $probability
     * @param Emitter $emitter
     */
    public function __construct($factor, $probability, Emitter $emitter)
    {
        $this->factor      = $factor;
        $this->probability = $probability;
        $this->emitter = $emitter;
    }
}
