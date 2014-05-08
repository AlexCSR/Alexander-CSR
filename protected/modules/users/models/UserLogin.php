<?php

# ver: 1.2.0

class UserLogin extends CFormModel
{
	public $login;
	public $password;
	public $rememberMe;

	//----------------------------------------------------------------------------	 
	public function rules()
	//----------------------------------------------------------------------------	
	{
		return array(
			array('login', 'required'),
			array('rememberMe', 'boolean'),
			array('password', 'authenticate'),
		);
	}

	//----------------------------------------------------------------------------  
	public function attributeLabels()
	//----------------------------------------------------------------------------
	{
		return array(
			'rememberMe' => 'Запомнить меня',
			'login' => 'Логин',
			'password' => 'Пароль',
		);
	}

	//----------------------------------------------------------------------------
	public function authenticate($attribute, $params)
	//----------------------------------------------------------------------------
	{
		if(!$this->hasErrors())
		{
			$identity = new DUserIdentity($this->login, $this->password);
			$identity->authenticate();
			
			switch($identity->errorCode)
			{
				case DUserIdentity::ERROR_NONE:
					$duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 days
					Yii::app()->user->login($identity, $duration);
					break;
				case DUserIdentity::ERROR_USERNAME_INVALID:
				case DUserIdentity::ERROR_PASSWORD_INVALID:
					$this->addError("login", 'Неверное имя пользователя или пароль!');
					break;

				case DUserIdentity::ERROR_USER_BLOCKED:
					$this->addError("login", 'Ваш аккаунт заблокирован администратором');
					break;
			}

		}
	}
}
