<?php

# ver: 1.2.0

class ProfileController extends DcController
{

	public $defaultAction = 'view';
	public $defaultActionName = 'Мой профиль';

	//----------------------------------------------------------------------------
	public function actionView()
	//----------------------------------------------------------------------------
	{
		$modUser = $this->loadProfile();
		
		$this->pageTitle = 'Мой профиль';
		$this->menu = array(
										array('label' => 'Опции'), 
										array('label'=>'Редактировать', 
													'icon' => 'pencil',
													'url' => array('/users/profile/update'), 
													'visible' => Yii::app()->user->checkAccess('users/profile/update')),

										array('label'=>'Сменить пароль', 
													'icon' => 'lock',
													'url' => array('/users/profile/password'), 
													'visible' => Yii::app()->user->checkAccess('users/profile/password')),										
		);
		
		$this->render('/admin/view', array('modUser' => $modUser));
	}

	//----------------------------------------------------------------------------
	public function actionUpdate()
	//----------------------------------------------------------------------------
	{
		$modUser = $this->loadProfile();


		if(isset($_POST['UserProfile']))
		{
			$modUser->attributes = $_POST['UserProfile'];
			if($modUser->save())
				$this->redirectPageStatePrevious();
		}
		else $this->initPageStatePrevious(array('view', 'id' => $modUser->id)); // Переопределите если нужно


		$this->pageTitle = 'Редактировать';

		$this->render('update', array('modUser' => $modUser));
	}

	//----------------------------------------------------------------------------  
	public function actionPassword()
	//----------------------------------------------------------------------------  
	{

		$this->pageTitle = 'Смена пароля';

		$modPassword = new UserPassword;
		

		// Выполнить сохранение
		if(isset($_POST['UserPassword']))
		{
			$modPassword->attributes = $_POST['UserPassword'];
			if($modPassword->validate())
			{
				$modUser = User::model()->findByPk(Yii::app()->user->id);
				$modUser->changePassword($modPassword->password);
				if ($modUser->save())
				{
					Yii::app()->user->setFlash('info', 'Пароль успешно сменен.');
					$this->redirectPageStatePrevious();					
				}
			}
			else $modPassword->clearAttributes();
		} 
		else $this->initPageStatePrevious(array('update')); // Переопределите если нужно


		// Передать контроллеру    
		$this->render('/admin/password', array('modPassword'=>$modPassword));
	}

	//----------------------------------------------------------------------------
	public function loadProfile()
	//----------------------------------------------------------------------------
	{
		$modUser = UserProfile::model()->findByPk(Yii::app()->user->id);
		if($modUser === null)
			throw new CHttpException(404,'Такой страницы нет!');
		return $modUser;
	}
}
