<?php

# ver: 1.2.0

//******************************************************************************
class UserProfile extends User
//******************************************************************************
{
	//----------------------------------------------------------------------------
	public function rules()
	//----------------------------------------------------------------------------	
	{
		return array(
				array('id', 'length', 'max'=>10, 'on' => 'import'),
				array('login, email', 'unique'),
				array('name, login', 'required'),
				array('tst_last_auth', 'length', 'max'=>10),
				array('url_role, name, login, email, recovery, password, salt', 'length', 'max'=>255),
		);;
	}

	public static function model($className=__CLASS__) {return parent::model($className);}
}