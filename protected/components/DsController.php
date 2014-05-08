<?php

# ver: 1.0.p.0
# com: Добавлены свойства showSlider и showNews

class DsController extends DController
{
	public $layout = '//layouts/site';
  	public $errorAction = '/site/site/error';

  	public $_browserTitle;
  	private $_breadcrumbsEnding;

  	public $showSlider = true;
  	public $showNews = true;

	//-------------------------------------------------------------------------
	public function getBrowserTitle()
	//-------------------------------------------------------------------------
	{
		return $this->_browserTitle !== null ? $this->_browserTitle : $this->pageTitle;
	}

	//-------------------------------------------------------------------------
	public function getBreadcrumbsEnding()
	//-------------------------------------------------------------------------
	{
		return $this->_breadcrumbsEnding !== null ? $this->_breadcrumbsEnding : $this->pageTitle;
	}

	//----------------------------------------------------------------------------
	public function accessDenied($message=null)
	//----------------------------------------------------------------------------	
	{
		if($message === null)
			$message = 'Авторизуйтесь чтобы продолжить';

		throw new CHttpException(404, $message);
	}

	public function setBrowserTitle($val) {$this->_browserTitle = $val;}

	public function setBreadcrumbsEnding($val) {$this->_breadcrumbsEnding = $val;}

}
