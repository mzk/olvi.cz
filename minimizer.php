<?php
namespace MatthiasMullie\Minify;
require __DIR__. '/vendor/autoload.php';

$css1 = (__DIR__.'/www/css/bootstrap.css');
$css2 = (__DIR__.'/www/css/style.css');

$minifier = new CSS($css1, $css2);

$minifier->minify(__DIR__.'/www/css/all.css');

$mobile = [];
$mobile[] = __DIR__.'/www/js/netteForms.js';
$mobile[] = __DIR__.'/www/js/scripts.js';


$minifierJs = new JS();

foreach ($mobile AS $f) {
	$minifierJs->add($f);
}
$minifierJs->minify(__DIR__.'/www/js/all-mobile.js');

$desktop = [];
$desktop[] = __DIR__.'/www/js/jquery-1.10.2.js';
$desktop[] = __DIR__.'/www/js/netteForms.js';
$desktop[] = __DIR__.'/www/js/nette.ajax.js';
$desktop[] = __DIR__.'/www/js/nette.history.js';
$desktop[] = __DIR__.'/www/js/scripts.js';


$minifierJs = new JS();

foreach ($desktop AS $f) {
	$minifierJs->add($f);
}

$minifierJs->minify(__DIR__.'/www/js/all-desktop.js');