<?php
include('vendor/autoload.php');

use VaneaVasco\Hetub\Mechanics\TurnManager as TurnManager;
use VaneaVasco\Hetub\Mechanics\GameEnd as GameEnd;

$heroFactory = new VaneaVasco\Hetub\Mechanics\HeroFactory();

$orderus = $heroFactory::create('Orderus', 'Orderus');
$beast   = $heroFactory::create('WildBeast', 'Brissleback');

$gameInstance = new VaneaVasco\Hetub\Mechanics\Game(['orderus' => $orderus, 'beast' => $beast], new TurnManager, new GameEnd);

$gameInstance->initGame();
$gameInstance->run();
