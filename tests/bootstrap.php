<?php

require __DIR__ . '/../vendor/autoload.php';

if (!class_exists('Tester\Assert')) {
	echo "Install Nette Tester using `composer update --dev`\n";
	exit(1);
}

$whoami = trim(shell_exec('whoami'));
if ($whoami != 'www-data') {
	echo "$whoami:";;
	echo "run as www-data";
	exit(1);
}

Tester\Environment::setup();

function id($val) {
	return $val;
}

$configurator = new Nette\Configurator;
$configurator->setDebugMode(true);
define('IS_DEVEL', true);
$configurator->setTempDirectory(__DIR__ . '/../temp');
$configurator->createRobotLoader()
	->addDirectory(__DIR__ . '/../app')
	->register();

$configurator->addConfig(__DIR__ . '/../app/config/config.neon');
$configurator->addConfig(__DIR__ . '/../app/config/config.local.neon');


include __DIR__.'/app/TestBaseCase.php';

return $configurator->createContainer();
