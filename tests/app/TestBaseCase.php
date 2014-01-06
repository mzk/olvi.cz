<?php

use Tester\Assert;

abstract class TestBaseCase extends Tester\TestCase
{
	/** @var  \Nette\Application\UI\Presenter */
	protected $presenter;

	/** @var \Nette\DI\Container */
	protected $container;
	protected $presenterName;

	/**
	 * @param \Nette\DI\Container $container
	 */
	function __construct(Nette\DI\Container $container)
	{
		$this->container = $container;
	}

	function init($presenterName)
	{
		$presenterFactory = $this->container->getByType('Nette\Application\IPresenterFactory');
		$this->presenter = $presenterFactory->createPresenter($presenterName);
		$this->presenter->autoCanonicalize = FALSE;
		$this->presenterName = $presenterName;
	}

	/**
	 * @param $action
	 * @param string $method
	 * @param array $params
	 * @param array $post
	 * @return \Nette\Application\IResponse
	 */
	public function test($action, $method = 'GET', $params = array(), $post = array())
	{
		$params['action'] = $action;
		$request = new \Nette\Application\Request($this->presenterName, $method, $params, $post);
		$response = $this->presenter->run($request);
		return $response;
	}

	/**
	 * @param $action
	 * @param string $method
	 * @param array $params
	 * @param array $post
	 * @return \Nette\Application\IResponse
	 */
	protected function testAction($action, $method = 'GET', $params = array(), $post = array())
	{
		$response = $this->test($action, $method, $params, $post);

		\Tester\Assert::true($response instanceof \Nette\Application\Responses\TextResponse);
		\Tester\Assert::true($response->getSource() instanceof \Nette\Templating\ITemplate);

		$html = (string)$response->getSource();
		$dom = \Tester\DomQuery::fromHtml($html);
		\Tester\Assert::true($dom->has('title'));

		return $response;
	}

	/**
	 * @param $action
	 * @param string $method
	 * @param array $post
	 * @return \Nette\Application\IResponse
	 */
	protected function testForm($action, $method = 'POST', $post = array())
	{
		$response = $this->test($action, $method, $post);
		\Tester\Assert::true($response instanceof \Nette\Application\Responses\RedirectResponse);
		return $response;
	}


	/**
	 * @param \Nette\Application\IResponse $response
	 * @return string $reponse->getSource()
	 */
	protected function isTextResponse($response)
	{
		if (!$response instanceof Nette\Application\Responses\TextResponse) {
			Assert::fail("Response isn't Text Response");
		}
		if (!$response->getSource() instanceof Nette\Templating\Template) {
			Assert::fail("Response isn't Template");
		}
		return (string)$response->getSource();
	}

	/**
	 * ocekavame redirect
	 * @param \Nette\Application\IResponse $response
	 */
	protected function isRedirectResponse($response)
	{
		if (!$response instanceof Nette\Application\Responses\RedirectResponse) {
			Assert::fail("Response is'nt Redirect Response");
		}
	}

	/**
	 * ocekavame BadRequestException
	 * @param $request
	 */
	protected function isBadRequestException($request)
	{
		try {
			$this->presenter->run($request);
			Assert::fail('isBadRequestException() fail');
		} catch (Nette\Application\BadRequestException $e) {
			Assert::true(true);
		}
	}

	/**
	 * ocekavame ForbiddenRequestException
	 * @param \Nette\Application\Request $request
	 */
	protected function isForbiddenRequestException($request)
	{
		try {
			$this->presenter->run($request);
			Assert::fail('isForbiddenRequestException fail');
		} catch (Nette\Application\ForbiddenRequestException $e) {
			Assert::true(true);
		}
	}

	/**
	 * ocekavame ze dom bude obsahovat selector
	 * @param string $html
	 * @param string $selector
	 */
	protected function domHasSelector($html, $selector)
	{
		$dom = \Tester\DomQuery::fromHtml($html);
		Assert::true($dom->has($selector));
	}

	/**
	 * ocekavame ze dom NEbude obsahovat selector
	 * @param string $html
	 * @param string $selector
	 */
	protected function domDoesNotHaveSelector($html, $selector)
	{
		$dom = \Tester\DomQuery::fromHtml($html);
		Assert::false($dom->has($selector));
	}

	/**
	 * @param \Nette\Application\Responses\TextResponse $response
	 * @return mixed JSON
	 */
	protected function getJson($response)
	{
		return json_decode((string)$response->getSource());
	}

	/**
	 * save string to html file for explore
	 * @param $source
	 */
	protected function write($source)
	{
		file_put_contents(__DIR__ . '/../../temp/' . get_called_class() . '-' . rand(1, 99) . '.html', (string)$source->getSource());
	}
}
