<?php

$container = require $argv[1];
require __DIR__ . "/../src/PhpStanLatteDumper.php";
$latte = $container->getService("latte.templateFactory")->createTemplate()->getLatte();
(new Metis\Dev\PhpStanLatteDumper($latte))->dumpLatte($argv[2], $argv[3]);
