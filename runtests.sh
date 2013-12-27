#!/bin/sh

res1=$(date +%s.%N)

aopt=false
bopt=false
copt=false
dopt=false
eopt=false
fopt=false
gopt=false
hopt=true

while getopts 'abcdefg' opt; do
	case "$opt" in
	a)
		hopt=false
		aopt=true ;;
	b)
		hopt=false
		bopt=true ;;
	c)
		hopt=false
		copt=true ;;
	e)
		hopt=false
		eopt=true ;;
	f)
		hopt=false
		fopt=true ;;
	g)
		hopt=false
		gopt=true ;;
	d)
		hopt=false
		aopt=true
		bopt=true
		copt=true
		eopt=true
		fopt=true
		dopt=true ;;
	esac
done

if $aopt; then
	echo "\n\033[1;32m================= code-checker.php ================\033[0m"
	php tests/code-checker.php -l;
fi

if $bopt; then
	echo "\n\033[1;32m================= checkSyntax.sh ==================\033[0m";
	./tests/checkSyntax.sh
fi

if $fopt; then
	echo "\n\033[1;32m================= Find dump, die, exit etc ====================\033[0m"
	php ./tests/find-dumps.php
fi

if $eopt; then
	echo "\n\033[1;32m================= Copy database ====================\033[0m"
	su www-data -c 'php ./_tests/copy-database.php'
fi

if $copt; then
	echo "\n\033[1;32m================= Nette Tester ====================\033[0m"
	su www-data -c 'php ./vendor/nette/tester/Tester/tester.php -s -c /etc/php5/apache2/php.ini -log ./log/tests.output.html --debug ./tests/ -j 1'
fi

if $gopt; then
	echo "\n\033[1;32m================= Code coverage report ====================\033[0m"
	su www-data -c 'php ./vendor/nette/tester/Tester/coverage-report.php -c _logs/coverage.dat -s _app/ -o _logs/coverage.html'
fi


if $hopt; then
	echo "use -a for code-checker.php -l"
	echo "use -b for checkSyntax.sh"
	echo "use -c for Nette Tester"
	echo "use -e for copy master database to test database"
	echo "use -f for finding dump, die, exit, etc"
	echo "use -g for create HTML code coverage report"
	echo "use -d for all tests"
fi

res2=$(date +%s.%N)
echo "\n"
echo "Elapsed:    $(echo "$res2 - $res1"|bc )"


#./deleteCache.sh
#
# Options:
#  	-p <php>    Specify PHP-CGI executable to run.
#  	-c <path>   Look for php.ini in directory <path> or use <path> as php.ini.
#  	-log <path> Write log to file <path>.
#  	-d key=val  Define INI entry 'key' with value 'val'.
#  	-s          Show information about skipped tests.
#  	-j <num>    Run <num> jobs in parallel.
#