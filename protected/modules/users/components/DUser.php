<?php

# ver: 1.2.0.1
# Исправлена ошибка валидации recovery

//******************************************************************************
class DUser extends DActiveRecord
//******************************************************************************
{
	public $request; // Поисковый запрос
	public $flg_active = 1;

	//----------------------------------------------------------------------------
	public function attributeLabels()
	//----------------------------------------------------------------------------  
	{
		return array(
			'enum.url_role' => 'Роль',
			'url_role' => 'Роль',
			'name' => 'Имя',
			'login' => 'Логин',
			'email' => 'Email',
			'password' => 'Пароль',
			'flg_active' => 'Активен',
		);
	}

	//----------------------------------------------------------------------------
	public function rules()
	//----------------------------------------------------------------------------	
	{
		return array(
			array('url_role, name, login, email, password, salt', 'length', 'max'=>255),
			array('email', 'email'),
			array('login', 'unique'),
			array('name, login', 'required'),

			array('password', 'required', 'on' => 'insert'),
			array('password', 'password', 'on' => 'insert'),


			// Поиск
			array('request', 'safe', 'on'=>'search'),
		);
	}

	//****************************************************************************
	//	ГЕТТЕРЫ
	//****************************************************************************

	//----------------------------------------------------------------------------
	public function password()
	//----------------------------------------------------------------------------
	{
		if ($this->password != '') 
			$this->changePassword($this->password);
	}

	//----------------------------------------------------------------------------
	public function changePassword($strPassword)
	//----------------------------------------------------------------------------
	{
		$this->salt = md5(uniqid());
		$this->password = md5($this->salt . $strPassword);
	}

	//----------------------------------------------------------------------------
	public function getEnum_url_role()
	//----------------------------------------------------------------------------  
	{
	  if ($this->_enum_url_role == null)
	  {
	    $this->_enum_url_role = array();
	    foreach (Yii::app()->authManager->roles as $url_role => $obj_role)
	      $this->_enum_url_role[$url_role] = $obj_role->description;
	  }
	  return $this->_enum_url_role;
	}
	private $_enum_url_role;

	//----------------------------------------------------------------------------
	public function getNames()
	//----------------------------------------------------------------------------
	{
		$arrRet = array();
		
		$dr = Yii::app()->db->createCommand('SELECT id, name FROM tbl_users ORDER BY name')->query();
		while ($t = $dr->read())
			$arrRet[$t['id']] = $t['name'];
		
		return $arrRet;
	}	

	//----------------------------------------------------------------------------
	public function getEnum()
	//----------------------------------------------------------------------------
	{
		return array(
			'url_role' => $this->enum_url_role[$this->url_role],
			);
	}

	//----------------------------------------------------------------------------
	public function getIsActive()
	//----------------------------------------------------------------------------
	{
		return $this->flg_active == 1;
	}

	//****************************************************************************
	//	СЛУЖЕБНЫЕ ФУНКЦИИ
	//****************************************************************************

	//----------------------------------------------------------------------------
	public function findByLogin($login)
	//----------------------------------------------------------------------------
	{
		return $this->findByAttributes(array('login' => $login));
	}

	//----------------------------------------------------------------------------
	public function search()
	//----------------------------------------------------------------------------
	{
		$objCriteria = new CDbCriteria;

		// Запрос по строке
		$objCriteria->compare('name', $this->request, true, 'OR');
		$objCriteria->compare('login', $this->request, true, 'OR');
		$objCriteria->compare('email', $this->request, true, 'OR');

		$objCriteria->order = 'name';

		return new CActiveDataProvider($this, array(
			'criteria' => $objCriteria,
			'sort' => false,
		));
	}

	public static function model($className=__CLASS__) {return parent::model($className);}
	public function tableName() {return 'tbl_users';}
}