#!/bin/sh
echo "\n find ../ *.php -not -path *vendor";
for f in `find -L -name "*.php" -not -path "*vendor*"`; do
	php -l $f | grep "Parse error"
	echo -n '.';
done


echo "\n find ../ *.phtml -not -path *vendor*";
for f in `find -L -name "*.phtml" -not -path "*vendor*"`; do
	php -l $f | grep "Parse error"
	echo -n '.';
done

echo "\n find ../ *.phpt -not -path *vendor*";
for f in `find -L -name "*.phpt" -not -path "*vendor*"`; do
	php -l $f | grep "Parse error"
	echo -n '.';
done