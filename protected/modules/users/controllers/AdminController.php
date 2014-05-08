<?php

# ver: 1.2.0

class AdminController extends DcController
{
	public $defaultAction = 'admin';
	public $defaultActionName = 'Пользователи';

	//----------------------------------------------------------------------------
	public function actionAdmin()
	//----------------------------------------------------------------------------
	{
		$modUser = new User('search');
		$modUser->unsetAttributes();
		
		if(isset($_GET['User'])) $modUser->attributes = $_GET['User'];

		$this->pageTitle = 'Пользователи';
		$this->menu = array(                          
										array('label' => 'Опции'), 
										array('label' => 'Добавить', 
													'icon' => 'plus',
													'url' => array('/users/admin/create'), 
													'visible' => Yii::app()->user->checkAccess('users/admin/create')),
		);


		$this->render('admin', array('modUser' => $modUser));
	}

	//----------------------------------------------------------------------------
	public function actionView($id)
	//----------------------------------------------------------------------------
	{
		$modUser = $this->loadModel($id);
		
		$this->pageTitle = $modUser->name;
		$this->menu = array(
										array('label' => 'Опции'), 
										array('label'=>'Редактировать', 
													'icon' => 'pencil',
													'url' => array('/users/admin/update', 'id' => $modUser->id), 
													'visible' => Yii::app()->user->checkAccess('users/admin/update')),

										array('label'=>'Сменить пароль', 
													'icon' => 'lock',
													'url' => array('/users/admin/password', 'id' => $modUser->id), 
													'visible' => Yii::app()->user->checkAccess('users/admin/password')),
										
										array('label'=>'Удалить', 
													'icon' => 'trash',
													'url' => '#', 
													'linkOptions'=>array('submit'=>array('/users/admin/delete', 'id' => $modUser->id), 'confirm'=>'Точно?'), 
													'visible' => Yii::app()->user->checkAccess('users/admin/delete')),
		);
		
		$this->render('view', array('modUser' => $modUser));
	}

	//----------------------------------------------------------------------------
	public function actionCreate()
	//----------------------------------------------------------------------------
	{
		$modUser = new User;

		if(isset($_POST['User']))
		{
			$modUser->attributes = $_POST['User'];
			if($modUser->save())
				$this->redirectPageStatePrevious();
		}
		else $this->initPageStatePrevious();

		$this->pageTitle = 'Добавить';

		$this->render('create', array('modUser' => $modUser));
	}

	//----------------------------------------------------------------------------
	public function actionUpdate($id)
	//----------------------------------------------------------------------------
	{
		$modUser = $this->loadModel($id);


		if(isset($_POST['User']))
		{
			$modUser->attributes = $_POST['User'];
			if($modUser->save())
				$this->redirectPageStatePrevious();
		}
		else $this->initPageStatePrevious(array('view', 'id' => $modUser->id)); // Переопределите если нужно

		$this->breadcrumbs[$modUser->name] = array('view', 'id' => $modUser->id);
		$this->pageTitle = 'Редактировать';

		$this->render('update', array('modUser' => $modUser));
	}

	//----------------------------------------------------------------------------  
	public function actionPassword($id)
	//----------------------------------------------------------------------------  
	{
		$modUser = $this->loadModel($id);

		$this->breadcrumbs = array(
			'Пользователи' => array('/users/admin/list'),
			$modUser->name => array('/users/admin/view', 'id' => $modUser->id));

		$this->pageTitle = 'Смена пароля';

		$modPassword = new UserPassword;

		// Выполнить сохранение
		if(isset($_POST['UserPassword']))
		{
			$modPassword->attributes = $_POST['UserPassword'];
			if($modPassword->validate())
			{
				$modUser = User::model()->findByPk($id);
				$modUser->changePassword($modPassword->password);
				if ($modUser->save())
				{
					Yii::app()->user->setFlash('info', 'Пароль успешно сменен.');
					$this->redirectPageStatePrevious();					
				}
			}
			else $modPassword->clearAttributes();
		} 
		else $this->initPageStatePrevious(array('view', 'id' => $id)); // Переопределите если нужно


		// Передать контроллеру    
		$this->render('password', array('modPassword'=>$modPassword));
	}

	//----------------------------------------------------------------------------
	public function actionDelete($id)
	//----------------------------------------------------------------------------  
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Ошибка запроса.');
	}

	//----------------------------------------------------------------------------
	public function loadModel($id)
	//----------------------------------------------------------------------------
	{
		$modUser = User::model()->findByPk($id);
		if($modUser === null)
			throw new CHttpException(404,'Такой страницы нет!');
		return $modUser;
	}
}
