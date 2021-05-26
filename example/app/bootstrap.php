<?php

require __DIR__ . '/../../vendor/autoload.php';

$configurator = new \Nette\Configurator;

$configurator->setDebugMode(true);
$configurator->setTempDirectory(__DIR__ . '/../temp');
$configurator->addConfig(__DIR__ . '/config.neon');
$container = $configurator->createContainer();

return $container;
