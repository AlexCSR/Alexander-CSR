<?php
# ver: 1.0.0
# req: /protected/modules/site/views/site/index.php
# req: /protected/modules/site/views/site/error.php

class SiteController extends DsController
{
	public $defaultAction = 'index'; // Действие по умолчанию
	public $defaultActionName = 'Главная'; // Действие по умолчанию

	//----------------------------------------------------------------------------
	public function actionIndex()
	//----------------------------------------------------------------------------
	// Отображение главной страницы
	{
		$this->breadcrumbs = null;
		$this->pageTitle = 'Главная страница';
		$this->render('index');
	}


	//----------------------------------------------------------------------------
	public function actionBlock()
	//----------------------------------------------------------------------------
	// Отображение главной страницы
	{
		$this->breadcrumbs = null;
		$this->pageTitle = 'Страница находится в разработке';
		$this->render('block');
	}

	//----------------------------------------------------------------------------
	public function actionSetLanguage($language)
	//----------------------------------------------------------------------------
	{
		$objLanguage = new DLanguage;
		$objLanguage->setLanguage($language);
		$this->redirectBack();
	}


  	//----------------------------------------------------------------------------
	public function actionLogin()
  	//----------------------------------------------------------------------------
	{
		$modLogin = new UserLogin;

		if(isset($_POST['UserLogin']))
		{
			$modLogin->attributes = $_POST['UserLogin'];
			$modLogin->validate(); 
		}

		$this->redirectBack();
	}

	//----------------------------------------------------------------------------
	public function actionLogout()
	//----------------------------------------------------------------------------
	{
		Yii::app()->user->logout();
		$this->redirect(array('/site/site/index'));
	}

}