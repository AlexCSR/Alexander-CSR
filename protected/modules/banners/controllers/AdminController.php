<?php

class AdminController extends DcController
{
	public $defaultAction = 'admin';
	public $defaultActionName = 'Баннеры';

	//----------------------------------------------------------------------------
	public function actionMoveUp($id)
	//----------------------------------------------------------------------------  
	{
		$this->loadModel($id)->incSort();
		$this->redirectBack();
	}

	//----------------------------------------------------------------------------
	public function actionMoveDown($id)
	//----------------------------------------------------------------------------  
	{
		$this->loadModel($id)->decSort();
		$this->redirectBack();
	}


	//----------------------------------------------------------------------------
	public function actionAdmin()
	//----------------------------------------------------------------------------
	{
		$modBanner = new Banner('search');
		$modBanner->unsetAttributes();
		
		if(isset($_GET['Banner'])) $modBanner->attributes = $_GET['Banner'];

		$this->pageTitle = 'Баннеры';
		$this->menu = array(                          
										array('label' => 'Опции'), 

		);


		$this->render('admin', array('modBanner' => $modBanner));
	}

	//----------------------------------------------------------------------------
	public function actionCreate($id_position)
	//----------------------------------------------------------------------------
	{
		$modBanner = new Banner;
		$modBanner->id_position = $id_position;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Banner']))
		{
			$modBanner->attributes = $_POST['Banner'];
			if($modBanner->save())
				$this->redirectPageStatePrevious();
		}
		else $this->initPageStatePrevious();

		$this->pageTitle = 'Добавить';

		$this->render('create', array('modBanner' => $modBanner));
	}

	//----------------------------------------------------------------------------
	public function actionUpdate($id)
	//----------------------------------------------------------------------------
	{
		$modBanner = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Banner']))
		{
			$modBanner->attributes = $_POST['Banner'];
			if($modBanner->save())
				$this->redirectPageStatePrevious();
		}
		else $this->initPageStatePrevious(array('view', 'id' => $modBanner->id)); // Переопределите если нужно


		$this->pageTitle = 'Редактировать';

		$this->render('update', array('modBanner' => $modBanner));
	}

	//----------------------------------------------------------------------------
	public function actionDelete($id)
	//----------------------------------------------------------------------------  
	{
		$this->loadModel($id)->delete();
		$this->redirectBack();
	}

	//----------------------------------------------------------------------------
	public function loadModel($id)
	//----------------------------------------------------------------------------
	{
		$modBanner = Banner::model()->findByPk($id);
		if($modBanner === null)
			throw new CHttpException(404,'Такой страницы нет!');
		return $modBanner;
	}
}
