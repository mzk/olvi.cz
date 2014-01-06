<?php
setLocale(LC_ALL, 'cs_CZ.utf8');
// Load Nette Framework or autoloader generated by Composer
require __DIR__ . '/../vendor/autoload.php';

Nette\Diagnostics\Debugger::timer();

$host = strtolower(rtrim($_SERVER['HTTP_HOST'], '.')); //odstrani posledni tecku z domeny a zmensi
if ($host != $_SERVER['HTTP_HOST']) {
	$url = 'http://' . $host . $_SERVER['REQUEST_URI'];
	header("HTTP/1.1 301 Moved Permanently");
	header('Location: ' . $url);
	header("Connection: close");
	die();
}


$configurator = new Nette\Configurator;

// Enable Nette Debugger for error visualisation & logging
$configurator->setDebugMode(IS_DEVEL);
$configurator->enableDebugger(__DIR__ . '/../log', 'error@mozektevidi.net');

// Specify folder for cache
$configurator->setTempDirectory(__DIR__ . '/../temp');

// Enable RobotLoader - this will load all classes automatically
$configurator->createRobotLoader()
	->addDirectory(__DIR__)
	->addDirectory(__DIR__ . '/../vendor/others')
	->register();

// Create Dependency Injection container from config.neon file
$configurator->addConfig(__DIR__ . '/config/config.neon');
$configurator->addConfig(__DIR__ . '/config/config.local.neon');
$container = $configurator->createContainer();
$container->application->catchExceptions = !IS_DEVEL;
return $container;
