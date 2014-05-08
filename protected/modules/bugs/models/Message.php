<?php

# ver: 1.0.0

//******************************************************************************
class Message extends DActiveRecord
//******************************************************************************
{
	public $request; // Поисковый запрос
	public $id_user;
	public $time;

	//****************************************************************************
	// AR - методы
	//****************************************************************************

	//----------------------------------------------------------------------------
	public function init()
	//----------------------------------------------------------------------------
	{
		$this->id_user = Yii::app()->user->id;
		$this->time = time()		;
	}

	//----------------------------------------------------------------------------
	public function attributeLabels()
	//----------------------------------------------------------------------------  
	{
		return array(
			'id_message' => 'Id Message',
			'id_bug' => 'Id Bug',
			'id_user' => 'Id User',
			'time' => 'Time',
			'text' => 'Text',
		);
	}

	//----------------------------------------------------------------------------
	public function rules()
	//----------------------------------------------------------------------------	
	{
		return array(
				array('id_bug, id_user, time', 'length', 'max'=>10),
				array('text', 'required'),
	
				// Внимание: удалите лишние атрибуты!
				array('id_message, id_bug, id_user, time, text, request', 'safe', 'on'=>'search'),
		);
	}

	//----------------------------------------------------------------------------
	public function relations()
	//----------------------------------------------------------------------------
	{
		// ВНИМАНИЕ: уточните имя связи
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'id_user'),
		);
	}

	//****************************************************************************
	// Пользовательские методы
	//****************************************************************************


	//****************************************************************************
	// Поиск
	//****************************************************************************

	//----------------------------------------------------------------------------
	public function search()
	//----------------------------------------------------------------------------
	{
		// Внимание: удалите лишние атрибуты!

		$objCriteria = new CDbCriteria;

		// Фильтрация полей
		$objCriteria->compare('id_message', $this->id_message, true);
		$objCriteria->compare('id_bug', $this->id_bug, true);
		$objCriteria->compare('id_user', $this->id_user, true);
		$objCriteria->compare('time', $this->time, true);
		$objCriteria->compare('text', $this->text, true);

		// Запрос по строке
		$objCriteria->compare('id_message', $this->request, false, 'OR');
		$objCriteria->compare('id_bug', $this->request, false, 'OR');
		$objCriteria->compare('id_user', $this->request, false, 'OR');
		$objCriteria->compare('time', $this->request, false, 'OR');
		$objCriteria->compare('text', $this->request, false, 'OR');


		return new CActiveDataProvider($this, array(
			'criteria' => $objCriteria,
		));
	}


	public static function model($className=__CLASS__) {return parent::model($className);}
	public function tableName() {return 'tbl_bug_messages';}
}