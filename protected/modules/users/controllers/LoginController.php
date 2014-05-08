<?php

# ver: 1.0.p.0.1
# com: Главная страница админки - pages/admin/admin

class LoginController extends DcController
{

  	//----------------------------------------------------------------------------
	public function actionLogin()
  	//----------------------------------------------------------------------------
	{
		$this->pageTitle = 'Вход в систему';
		$this->breadcrumbs = null;
		$this->showTitle = false;
		
	    if (Yii::app()->user->isGuest) 
	    {
			$modLogin = new UserLogin;

			if(isset($_POST['UserLogin']))
			{
				$modLogin->attributes = $_POST['UserLogin'];
				if($modLogin->validate()) $this->redirect(Yii::app()->user->returnUrl);
				else $modLogin->password = '';
			}
				
			$this->render('login', array('modLogin'=>$modLogin));
		} 
	    else $this->redirect(array('/pages/admin/admin'));
	}

	//----------------------------------------------------------------------------
	public function actionLogout()
	//----------------------------------------------------------------------------
	{
		Yii::app()->user->logout();
		$this->redirect(array('/pages/admin/admin'));
	}

}