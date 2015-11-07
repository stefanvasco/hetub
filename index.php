<?php
include('vendor/autoload.php');
use hetub\mechanics\TurnManager as TurnManager;
use hetub\mechanics\GameEnd as GameEnd;

$heroFactory = new hetub\mechanics\HeroFactory();

$orderus = $heroFactory::create('Orderus', 'Orderus');
$beast = $heroFactory::create('WildBeast', 'Brissleback');




$gameInstance = new hetub\mechanics\Game(['orderus' => $orderus, 'beast' => $beast], new TurnManager, new GameEnd);

$gameInstance->initGame();
$gameInstance->run();
