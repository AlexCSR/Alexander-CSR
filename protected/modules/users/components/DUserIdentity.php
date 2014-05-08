<?php

# ver: 1.2.0

class DUserIdentity extends CUserIdentity
{
	private $_id;
	
	const ERROR_USER_BLOCKED = 11;

	//----------------------------------------------------------------------------
	public function authenticate()
	//----------------------------------------------------------------------------
	{
		$modUser = User::model()->findByLogin($this->username);
		
		if($modUser === null) $this->errorCode = self::ERROR_USERNAME_INVALID;
		elseif($modUser->password !== md5($modUser->salt . $this->password)) $this->errorCode=self::ERROR_PASSWORD_INVALID;
		elseif (!$modUser->isActive) $this->errorCode=self::ERROR_USER_BLOCKED; 
		else
		{
			// Пользователь авторизован
			$this->_id = $modUser->id;
			$this->setState('name', $modUser->name);
			$this->errorCode=self::ERROR_NONE;
		}
		return !$this->errorCode;

	}

	//----------------------------------------------------------------------------
	public function getId()
	//----------------------------------------------------------------------------  
	{
		return $this->_id;
	}

}