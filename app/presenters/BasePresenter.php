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
		$this->template->pageName = '';
		$detect = new \MobileDetect();
		$this->template->isMobile = $detect->isMobile();
		$this->template->isDevel = IS_DEVEL;
	}

	protected function createTemplate($class = NULL)
	{
		$tpl = parent::createTemplate($class);

		$texy = new \Texy();

		$tpl->registerHelper('texy', callback($texy, 'process'));
		return $tpl;
	}

}
