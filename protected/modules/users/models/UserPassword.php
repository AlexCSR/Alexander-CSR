<?php

# ver: 1.0.0

class UserPassword extends CFormModel
{
	public $password;
	public $confirm;

	//----------------------------------------------------------------------------
	public function rules()
	//----------------------------------------------------------------------------
	{
		return array(
			array('password, confirm', 'required'),
			array('confirm', 'compare', 'compareAttribute'=>'password', 'message' => 'Введенные пароли должны быть слегка более похожи...'),
		);
	}

	//----------------------------------------------------------------------------
	public function clearAttributes()
	//----------------------------------------------------------------------------  
	{
		$this->password = '';
		$this->confirm = '';
	}

	//----------------------------------------------------------------------------
	public function attributeLabels()
	//----------------------------------------------------------------------------	
	{
		return array(
			'password' => 'Новый пароль',
			'confirm' => 'И еще раз',
		);
	}
}
