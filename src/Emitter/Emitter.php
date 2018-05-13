<?php

namespace VaneaVasco\Hetub\Emitter;


/**
 * Class Emitter
 * @package VaneaVasco\Hetub\Emitter
 */
class Emitter
{
    /**
     * @var static
     */
    protected static $instance;

    /**
     * @var Listener[]
     */
    protected $listeners;

    /**
     * @return static
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Emitter constructor.
     */
    protected function __construct()
    {
        $this->listeners = [];
    }

    protected function __clone()
    {
        // TODO: Implement __clone() method.
    }

    /**
     * @param $event
     * @param $listener
     */
    public function addListener($event, $listener)
    {
        $this->listeners[$event][] = $listener;
    }

    /**
     * @return array|Listener[]
     */
    public function getListeners()
    {
        return $this->listeners;
    }

    /**
     * @param $event
     */
    public function emit($event)
    {
        if (!array_key_exists($event, $this->listeners)) {
            //silent fail
            return;
        }
        $arguments = [$event] + func_get_args();
        foreach ($this->listeners[$event] as $listener) {
            call_user_func_array([$listener, 'handle'], $arguments);
        }
    }
}