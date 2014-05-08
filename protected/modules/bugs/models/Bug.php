<?php

# ver: 1.0.0

//******************************************************************************
class Bug extends DActiveRecord
//******************************************************************************
{
	public $request; // Поисковый запрос
	public $request_new = 0;

	public $time_detected;

	// Приоритет
	const PRIORITY_LOW = 0;
	const PRIORITY_HIGH = 1;
	public $id_priority = self::PRIORITY_LOW;

	// Статус
	const STATE_NEW = 0;
	const STATE_PROCESS = 10;
	const STATE_DONE = 20;
	const STATE_PAUSE = 25;
	const STATE_FIXED = 30;

	public $enum_id_state = array(
		self::STATE_NEW => 'Новая', 
		self::STATE_PROCESS => 'В работе', 
		self::STATE_DONE => 'Готово', 
		self::STATE_PAUSE => 'Отложено', 
		self::STATE_FIXED => 'Закрыто');

	public $id_state = self::STATE_NEW;

	// Тип
	const TYPE_BUG = 0;
	const TYPE_FITCH = 1;
	public $enum_id_type = array(self::TYPE_BUG => 'Ошибка', self::TYPE_FITCH => 'Пожелание');
	public $id_type = self::TYPE_BUG;


	//****************************************************************************
	// AR - методы
	//****************************************************************************

	//----------------------------------------------------------------------------
	public function init()
	//----------------------------------------------------------------------------
	{
		$this->id_user = Yii::app()->user->id;
		$this->time_detected = time();
	}

	//----------------------------------------------------------------------------
	public function attributeLabels()
	//----------------------------------------------------------------------------  
	{
		return array(
			'id' => 'ID',
			'name' => 'Заголовок',
			'url' => 'Адрес страницы',
			'id_priority' => 'Важная',
			'id_state' => 'Статус',
			'id_type' => 'Тип',
			'description' => 'Описание',
			'reply' => 'Комментарий',
			'id_user' => 'Обнаружил',
			'time_detected' => 'Обнаружено',
			'time_done' => 'Исправлено',
		);
	}

	//----------------------------------------------------------------------------
	public function rules()
	//----------------------------------------------------------------------------	
	{
		return array(
				array('name, url', 'length', 'max'=>255),
				array('id_priority, id_state, id_type, time_detected, time_done', 'length', 'max'=>10),
				array('id_user', 'length', 'max'=>45),
				array('description, reply', 'safe'),
				array('name', 'required'),
				array('time_detected, time_done', 'DTimestampValidator'),

				// Внимание: удалите лишние атрибуты!
				array('request, request_new', 'safe', 'on'=>'search'),
		);
	}

	//----------------------------------------------------------------------------
	public function relations()
	//----------------------------------------------------------------------------
	{
		// ВНИМАНИЕ: уточните имя связи
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'id_user'),
			'messages' => array(self::HAS_MANY, 'Message', 'id_bug', 'order' => 'time ASC', 'with' => array('user')),
		);
	}


	//----------------------------------------------------------------------------
	public function afterDelete()
	//----------------------------------------------------------------------------
	{
		parent::afterDelete();
		foreach ($this->messages as $modMessage) $modMessage->delete();
	}

	//****************************************************************************
	// Пользовательские методы
	//****************************************************************************

	//----------------------------------------------------------------------------
	public function getEnum()
	//----------------------------------------------------------------------------
	{
		return array(
			'id_state' => $this->enum_id_state[$this->id_state],
			'id_type' => $this->enum_id_type[$this->id_type],
			);	
	}


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
		if ($this->request_new == 0)
			$objCriteria->addNotInCondition('id_state', array(self::STATE_FIXED));

		// Запрос по строке
		$objCriteria->compare('name', $this->request, false, 'OR');
		$objCriteria->compare('description', $this->request, false, 'OR');


		return new CActiveDataProvider($this, array(
			'pagination' => array('pageSize' => 25),
			'criteria' => $objCriteria,
			'sort' => array('defaultOrder' => array('id' => CSort::SORT_DESC))
		));
	}


	public static function model($className=__CLASS__) {return parent::model($className);}
	public function tableName() {return 'tbl_bugs';}
}