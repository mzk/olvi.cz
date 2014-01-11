<?php
namespace Test\app;

use Nette\Application\BadRequestException;
use Tester\Assert;

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


	/**
	 * @dataProvider getStaticPages
	 */
	function testRenderStatic($page)
	{
		$response = $this->testAction('static', 'GET', ['page' => $page]);
	}

	function getStaticPages()
	{
		return [['adresa'], ['kontakty'], ['o-nas'], ['oleje'], ['oleje-recepty'], ['oteviraci-doba'], ['vino']];
	}

	/**
	 * @throws Nette\Application\BadRequestException
	 */
	function testRender404()
	{
		$response = $this->testAction('static', 'GET', ['page' => 'foo']);
	}

	function testRender404text()
	{
		try {
			$response = $this->test('static', 'GET', ['page' => 'foo']);
			Assert::fail('Exception not trow');
		} catch (BadRequestException $e) {

		}
	}

}

id(new HomepagePresenterTest($container))->run();
