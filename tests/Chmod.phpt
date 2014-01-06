<?php

use Tester\Assert;

$container = require __DIR__ . '/bootstrap.php';

class ChmodTest extends Tester\TestCase
{

	/**
	 * @dataProvider getDirectoryToCheck
	 */
	function testCheckChmod($path, $chmod = 777)
	{
		if (!is_dir($path)) { // kontrolujeme ci existuje directory
			Assert::fail('Directory: ' . $path . ' does not exist');
		}
		clearstatcache(null, $path);
		$result = intval(substr(decoct(fileperms($path)), -3));

		if ($result != $chmod) { // kontrolujeme permission
			Assert::fail('Bad permission in directory: ' . $path . ' result: ' . $result . ' != ' . $chmod);
		}
		// pokusame sa vytvorit subor
		$fileName = $path . uniqid() . '.tmp';
		@file_put_contents($fileName, \Nette\Utils\Strings::random()); //zde potlacime error

		if ($chmod == 777 && !file_exists($fileName)) { //mel by existovat a NENI
			Assert::fail("PHP can't create temporary file");
		}

		if ($chmod != 777 && file_exists($fileName)) { //nemel by existovat a JE
			Assert::fail('file exists, but it should not be: ' . $fileName);
		}

		@unlink($fileName);

	}

	function getDirectoryToCheck()
	{
		$params = array(
			array(__DIR__.'/../temp/'),
			array(__DIR__.'/../log/'),
			array(__DIR__.'/../app/', 755),
			array(__DIR__.'/../vendor/', 755)
		);
		return $params;
	}


	/**
	 * @todo
	 */
	function testFilePermission()
	{

	}


}

id(new ChmodTest ($container))->run();