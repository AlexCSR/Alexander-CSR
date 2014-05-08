<?php

# ver: 1.0.p.0.1
# com: Добавлен функционал обратного звонка 

//******************************************************************************
class Feedback extends DActiveRecord
//******************************************************************************
{

  public $flg_new = 1;
  public $verifyCode;  // Код подтверждения

	public static function model($className=__CLASS__) {return parent::model($className);}


	public function tableName() {return 'tbl_feedback';}

  public function init()
  {
    $this->tst_create = time();
  }

  //----------------------------------------------------------------------------
  public function attributeLabels()
  //----------------------------------------------------------------------------  
	{
		return array(
			'tst_create' => 'Отправлено',
			'name' => 'Ваше имя',
			'email' => 'Email',
      'phone' => 'Номер телефона',
			'text' => 'Текст сообщения',
      'verifyCode' => 'Введите текст',
      'flg_phonecall' => 'Обратный звонок'
		);
	}

  //----------------------------------------------------------------------------
  public function getCountNew()
  //----------------------------------------------------------------------------
  {
    return Yii::app()->db->createCommand('SELECT count(id) FROM tbl_feedback WHERE flg_new = 1')->queryScalar();
  }

  //----------------------------------------------------------------------------
  public function getIsNew()
  //----------------------------------------------------------------------------
  {
    return $this->flg_new == 1;
  }

  //----------------------------------------------------------------------------
  public function getIsCallback()
  //----------------------------------------------------------------------------
  {
    return $this->flg_phonecall == 1;
  }

  //----------------------------------------------------------------------------
	public function rules()
  //----------------------------------------------------------------------------	
  {
    return array(

      array('name', 'required'),

      array('email', 'required', 'on' => 'feedback'),
      array('phone', 'required', 'on' => 'callback'),

      array('verifyCode', 'captcha', 'on' => 'feedback'),
      array('tst_create', 'length', 'max'=>10),

      array('flg_new', 'numerical', 'integerOnly'=>true),
      array('name, email, phone', 'length', 'max'=>255),
      array('email', 'email'),
      array('text', 'safe'),
    );
  }

  //----------------------------------------------------------------------------
  public function setDbCriteriaAdmin($strRequest)
  //----------------------------------------------------------------------------  
  {
    $criteria = new CDbCriteria;

		// Внимание: удалите лишние атрибуты!
		$criteria->compare('name', $strRequest, true, 'OR');
		$criteria->compare('email', $strRequest, true, 'OR');
		$criteria->compare('text', $strRequest, true, 'OR');

    $this->dbCriteria = $criteria;
  }


   //----------------------------------------------------------------------------
 public function search()
  //----------------------------------------------------------------------------
  {
    return new CActiveDataProvider($this);
  }
}