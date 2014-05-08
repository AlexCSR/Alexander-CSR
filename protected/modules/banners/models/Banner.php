<?php

//******************************************************************************
class Banner extends DActiveRecord
//******************************************************************************
{
	public $request; // Поисковый запрос

	const POSITION_TOP = 0;
	const POSITION_RIGHT = 1;


	//----------------------------------------------------------------------------
	public function attributeLabels()
	//----------------------------------------------------------------------------  
	{
		return array(
			'id_image' => 'Картинка',
			'link' => 'Ссылка',
			'description' => 'Описание',
			'name' => 'Заголовок',
		);
	}

	//----------------------------------------------------------------------------
	public function rules()
	//----------------------------------------------------------------------------	
	{
		return array(
				array('id_image, link, name', 'length', 'max'=>255),
				array('description', 'safe'),
				array('link, name', 'required'),
				array('id_image', 'DImageValidator'),
				
				// Внимание: удалите лишние атрибуты!
				array('link, description, request', 'safe', 'on'=>'search'),
		);
	}

	//----------------------------------------------------------------------------
	public function relations()
	//----------------------------------------------------------------------------
	{
		// ВНИМАНИЕ: уточните имя связи
		return array(
			'image' => array(self::BELONGS_TO, 'File', 'id_image'),
		);
	}

	//----------------------------------------------------------------------------
	public function scopes()
	//----------------------------------------------------------------------------
	{
		return array(
			'top' => array('condition' => 'id_position = ' . self::POSITION_TOP, 'with' => 'image', 'order' => 'id_sort'),
			'right' => array('condition' => 'id_position = ' . self::POSITION_RIGHT, 'with' => 'image', 'order' => 'id_sort'),
			);		
	}

	//----------------------------------------------------------------------------
	public function behaviors() 
	//----------------------------------------------------------------------------
	{
		return array(
			'sort' => array('class' => 'DActiveRecordSortBehavior', 'idParent' => 'id_position'),
			'file' => array('class' => 'DActiveRecordFileBehavior'),
		);
	}

	//----------------------------------------------------------------------------
	public function search()
	//----------------------------------------------------------------------------
	{
		// Внимание: удалите лишние атрибуты!

		$objCriteria = new CDbCriteria;
		$objCriteria->order = 'id_sort';
		$objCriteria->with = array('image');

		return new CActiveDataProvider($this, array(
			'criteria' => $objCriteria,
		));
	}


	public static function model($className=__CLASS__) {return parent::model($className);}
	public function tableName() {return 'tbl_banners';}
}