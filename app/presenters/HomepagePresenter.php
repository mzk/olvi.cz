<?php

namespace App;

use Nette, Model;


/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter
{

	public function renderDefault()
	{
		$this->template->pageName = 'default';
	}

	public function renderStatic($page)
	{
		$allowed = "/[^a-z0-9\\-]/";
		$escapedName = preg_replace($allowed,"",$page);
		if ($page != $escapedName) {
			throw new Nette\Application\BadRequestException();
		}
		$this->template->pageName = $escapedName;
		$this->template->title = $escapedName;
	}

}
