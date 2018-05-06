<?php
include('vendor/autoload.php');

use VaneaVasco\Hetub\Mechanics\TurnManager;
use VaneaVasco\Hetub\Mechanics\GameEnd;

$profilesStorageLocation = 'data/Profiles/';
$emitter                 = \VaneaVasco\Hetub\Emitter\Emitter::getInstance();
$heroFactory             = new \VaneaVasco\Hetub\Hero\Factory\HeroFactory();
$skillsFactory           = new \VaneaVasco\Hetub\Skill\Factory\SkillFactory();
$heroJsonGateway         = new \VaneaVasco\Hetub\Hero\Gateway\HeroJSON($profilesStorageLocation);
$heroRepository          = new \VaneaVasco\Hetub\Hero\Repository\HeroRepository($heroFactory, $skillsFactory, $heroJsonGateway);

$textDisplay = new \VaneaVasco\Hetub\Display\Message();

$emitter->addListener('game.won', $textDisplay);
$emitter->addListener('game.start', $textDisplay);
$emitter->addListener('game.stats', $textDisplay);
$emitter->addListener('hero.event', $textDisplay);

$orderus = $heroRepository->getHero('Orderus', 'Orderus the short');
$beast   = $heroRepository->getHero('WildBeast', 'Brissleback');

$gameInstance = new VaneaVasco\Hetub\Mechanics\Game(['orderus' => $orderus, 'beast' => $beast], new TurnManager, new GameEnd, $emitter);

$gameInstance->initGame();
$gameInstance->run();
