<?php
echo "\n Start minimizer at: " . date('d.m.Y H:i:s');

define('OUTPUT_CSS_FILE', 'www/css/all.css');
define('OUTPUT_JS_MOBILE_FILE', 'www/js/all-mobile.js');
define('OUTPUT_JS_DESKTOP_FILE', 'www/js/all-desktop.js');

function minimizeJob($files, $outputFile) {
	unlink($outputFile); //delete old file
	exec('echo "/* generated ' . date('d.m.Y H:i:s') . ' */ \n" > ' . $outputFile);
	foreach ($files AS $c) {
		echo "\n Minify " . $c;
		exec('echo "\n /* ' . basename($c) . ' */ \n" >> ' . $outputFile);
		exec('java -jar vendor/packagist/yuicompressor-bin/bin/yuicompressor.jar ' . $c . ' >> ' . $outputFile);
	}
}

$css[] = (__DIR__ . '/www/css/bootstrap.css');
$css[] = (__DIR__ . '/www/css/style.css');

$mobile[] = __DIR__ . '/www/js/netteForms.js';
$mobile[] = __DIR__ . '/www/js/scripts.js';

$desktop[] = __DIR__ . '/www/js/jquery-2.0.3.js';
$desktop[] = __DIR__ . '/www/js/netteForms.js';
$desktop[] = __DIR__ . '/www/js/nette.ajax.js';
$desktop[] = __DIR__ . '/www/js/nette.history.js';
$desktop[] = __DIR__ . '/www/js/scripts.js';

minimizeJob($css, OUTPUT_CSS_FILE);
minimizeJob($mobile, OUTPUT_JS_MOBILE_FILE);
minimizeJob($desktop, OUTPUT_JS_DESKTOP_FILE);

echo "\n END minimizer at: " . date('d.m.Y H:i:s');