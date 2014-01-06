<?php
namespace Test\app;


use Nette\Application\Request;
use Tester\Assert;
use Tester\Dumper;
use Tester\TestCase;

$container = require __DIR__ . '/../bootstrap.php';

class HomepagePresenterTest extends \TestBaseCase
{
	function setUp()
	{
		$this->init('Homepage');
	}

	function testRenderDefault()
	{
		$response = $this->test('default');
	}

}

id(new HomepagePresenterTest($container))->run();