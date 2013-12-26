<?php

// Uncomment this line if you must temporarily take down your site for maintenance.
// require '.maintenance.php';

if (file_exists(__DIR__ . '/../.DEVEL')) {
	define('IS_DEVEL', TRUE);
} else {
	define('IS_DEVEL', TRUE);
}

// Let bootstrap create Dependency Injection container.
$container = require __DIR__ . '/../app/bootstrap.php';

// Run application.
$container->getService('application')
	->run();
