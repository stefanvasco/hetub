<?php

namespace VaneaVasco\Hetub\Display;

use VaneaVasco\Hetub\Emitter\Listener;

/**
 * Class Message
 * @package VaneaVasco\Hetub\Display
 */
class Message implements Listener
{
    /**
     * @param $message
     */
    public static function display($message)
    {
        echo "$message \n";
    }

    /**
     *
     */
    public function handle()
    {
        $arguments = func_get_args();
        if (count($arguments) > 1) {
            Message::display($arguments[1]);
        }
    }

    protected function displayGameStart()
    {

    }

    protected function displayGameWon()
    {

    }

    protected function displayGameStats()
    {

    }
}
