<?php

class IndexController extends CController
{
	public $layout = '//layout';
	public $defaultAction = 'index';

	public $showTitle = true;
	public $showBreadcrumbs = true;
	public $breadcrumbs = array();

	public function getViewPath()
	{
		return Yii::app()->viewPath;
	}

	//----------------------------------------------------------------------------
	public function actionIndex($tpl = 'index')
	//----------------------------------------------------------------------------
	{
		$this->pageTitle = ucfirst($tpl);
		$this->render($tpl, array('tpl' => $tpl));
	}
}