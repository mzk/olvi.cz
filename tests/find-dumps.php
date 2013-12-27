<?php /**
 * bash version

#!/bin/sh
echo "\n find *.php";
for f in `find -type f -name "*.php" -o -name "*.phtml" -o -name "*.html"`; do
cat $f | grep "dump("
echo -n '.';
done
 */

require __DIR__ . '/../vendor/nette/nette/Nette/loader.php';

Nette\Diagnostics\Debugger::$showLocation = false;

$searchStrings = array('dump', 'die(', 'exit', 'Debugger::log', 'echo', 'print', '$this->write');

$countOfFound = 0;
$counter = 0;
foreach (\Nette\Utils\Finder::findFiles(array('*.php', '*.phpt', '*.phtml'))
			 ->exclude(array('*find-dumps.php', '*code-checker.php', '*copy-database.php', 'vendor'))
			 ->from(array(__DIR__.'/../app/', __DIR__.'/../www/')) AS $key => $file) {
	//echo exec("echo -n '.'");
	echo str_pad(str_repeat('.', $counter++ % 40), 40), "\x0D";
	$source = file($key);
	$source = str_replace(array("\r\n", "\r"), "\n", $source);
	foreach ($source AS $numberOfLine => $line) {
		$numberOfLine = $numberOfLine + 1; //radky se cisluji od 1;
		foreach ($searchStrings AS $ss) {
			if (stripos($line, $ss) !== false) {

				if ($ss == 'echo' && substr($file, -6) == '.phtml') { //echo v html sablone dovoluji, je jich hodne.
					echo "\n echo in phtml skipping\n";
					continue;
				}

				$countOfFound++;
				if ($countOfFound > 50) {
					break;
				}

				echo "\n" . "\033[1;33m" . "found $ss() in $key:$numberOfLine" . "\033[0m" . "\n";
				$found = \Nette\Diagnostics\BlueScreen::highlightFile($key, $numberOfLine, 4);
				$found = strip_tags($found);
				$found = htmlspecialchars_decode($found);
				$found = html_entity_decode($found);
				$found = str_ireplace('  ', '', $found);
				$found = str_ireplace($ss, "\033[1;31m" . $ss . "\033[0m", $found);
				echo($found);
				echo "\n\n";
			}
			//continue;
		}
	}
}
echo "\n Found $countOfFound results \n";
