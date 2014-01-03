<?php

namespace App;

use Nette, Model;


/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter
{

	function afterRender()
	{
		if ($this->isAjax()) {
			$this->redrawControl('content');
		}
	}

	public function renderDefault()
	{
		$this->template->pageName = 'default';
	}

	public function renderStatic($page)
	{
		$allowed = "/[^a-z0-9\\-]/";
		$escapedName = preg_replace($allowed, "", $page);
		if ($page != $escapedName) {
			throw new Nette\Application\BadRequestException();
		}

		if (file_exists(__DIR__ . '/../templates/Static/' . $escapedName . '.phtml')) {
			$this->template->pageName = $escapedName;
			$this->template->title = $escapedName;
		} else {
			throw new Nette\Application\BadRequestException;
		}
	}

}
