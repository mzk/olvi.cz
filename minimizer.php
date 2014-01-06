<?php
namespace MatthiasMullie\Minify;
require __DIR__. '/vendor/autoload.php';

/**
 * CSS
 */
$css[] = (__DIR__.'/www/css/bootstrap.css');
$css[] = (__DIR__.'/www/css/style.css');

$minifier = new CSS();

foreach ($css AS $c) {
	$minifier->add($c);
}
$minifier->minify(__DIR__.'/www/css/all.css');


/**
 * Javascript Mobile
 */
$mobile = [];
$mobile[] = __DIR__.'/www/js/netteForms.js';
$mobile[] = __DIR__.'/www/js/scripts.js';

$minifierJs = new JS();

foreach ($mobile AS $f) {
	$minifierJs->add($f);
}
$minifierJs->minify(__DIR__.'/www/js/all-mobile.js');


/**
 * Javascript Desktop
 */
$desktop = [];
$desktop[] = __DIR__.'/www/js/jquery-2.0.3.js';
$desktop[] = __DIR__.'/www/js/netteForms.js';
$desktop[] = __DIR__.'/www/js/nette.ajax.js';
$desktop[] = __DIR__.'/www/js/nette.history.js';
$desktop[] = __DIR__.'/www/js/scripts.js';

$minifierJs = new JS();

foreach ($desktop AS $f) {
	$minifierJs->add($f);
}

$minifierJs->minify(__DIR__.'/www/js/all-desktop.js');