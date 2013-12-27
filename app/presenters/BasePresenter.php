<?php

namespace App;

use Nette, Model;


/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
	public function beforeRender() {
		$this->invalidLinkMode = self::INVALID_LINK_EXCEPTION;
		$this->template->title = '';
	}

	protected function createTemplate($class = NULL)
	{
		$tpl = parent::createTemplate($class);

		// registrace Texy helperu
		$tpl->registerHelper('texy', callback(new \Texy(), 'process'));
		return $tpl;
	}

}
