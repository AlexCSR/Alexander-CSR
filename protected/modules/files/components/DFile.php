<?php

# ver: 1.1.0.1
# req: /protected/components/DActiveRecord.php 1.0, 1.1
# req: DFileValidator.php 1.0
# req: /protected/modules/files/models/File.php


//******************************************************************************
class DFile extends DActiveRecord
//******************************************************************************
{

	public $request; // Поисковый запрос
	public $id_parent = 0;

	//----------------------------------------------------------------------------
	public function attributeLabels()
	//----------------------------------------------------------------------------  
	{
		return array(
			'name' => 'Имя',
			'tst_upload' => 'Загружен',
			'source' => 'Файл',
			'size' => 'Размер',
		);
	}

	//----------------------------------------------------------------------------
	public function init()
	//----------------------------------------------------------------------------
	{
		parent::init();
		$this->tst_upload = time();
	}

	//----------------------------------------------------------------------------
	public function rules()
	//----------------------------------------------------------------------------	
	{
		return array(
				array('name', 'length', 'max'=>255),
				array('tst_upload, id_parent, flg_folder', 'length', 'max'=>10),
				array('source', 'file', 'on' => 'insert'),
				array('name', 'required', 'on' => 'folderInsert'),
				
				array('request, id_parent', 'length', 'max'=>255, 'on' => 'search'),

			);
	}

	//----------------------------------------------------------------------------
	public static function createByFile(CUploadedFile $objFile, $scenario = 'insert')
	//----------------------------------------------------------------------------
	{
		$modFile = new File($scenario);
		$modFile->name = $objFile->name;
		$modFile->source = $objFile;
		return $modFile;
	}

	//****************************************************************************
	// Геттеры
	//****************************************************************************

	// Настройки модуля
	public function getUploadPath()	{return Yii::app()->getModule("files")->uploadPath;}

	// Собственные настройки
	public function getContent() {return file_get_contents($this->sourcePath);}
	public function getSourcePath() {return $this->uploadPath . '/' . $this->source;}
	public function getAssetPath() {return $this->assetsPath . '/' . $this->source;}
	public function getDownloadUrl()	{return Yii::app()->createUrl(Yii::app()->getModule("files")->downloadRoute, array('id' => $this->id));}

	// Флаги
	public function getIsFolder() {return $this->flg_folder == 1;}
	public function getIsImage() {return $this->flg_image == 1;}

	public function getSize()	
	{
		if (!is_file($this->sourcePath)) return null;
		$intSize = @filesize($this->sourcePath);
		return $intSize ? $intSize : null;
	}

	//----------------------------------------------------------------------------
	public function beforeDelete()
	//----------------------------------------------------------------------------
	// Удаляет сам файл
	{
		if (!parent::beforeDelete()) return false;

		if (is_file($this->sourcePath))
			unlink($this->sourcePath);
		
		return true;
	}

	//----------------------------------------------------------------------------
	public function beforeSave()
	//----------------------------------------------------------------------------
	// Если источник - CUploadedFile, то сохранить его стандартным способом
	{
		if (!parent::beforeSave()) return false;

		// Загрузка файла без валидатора
		if ($this->source instanceof CUploadedFile)
		{
			$source = uniqid();
			
			// Создать подпапку
			if (!is_dir($this->uploadPath . '/' . $source[4]))
				mkdir($this->uploadPath . '/' . $source[4], 0777);

			$source = $source[4] . '/' . $source;
			$this->source->saveAs($this->uploadPath . '/' .  $source);
			$this->source = $source;
		}

		// Проверка того, что файл - картинка
		if ($this->isNewRecord && !$this->isFolder)
		{
			$validator = new DFileValidator;	
        	$this->flg_image = $validator->checkImage($this->sourcePath, &$arrErrors);
		}

		return true;
	}

	//----------------------------------------------------------------------------
	public function behaviors() 
	//----------------------------------------------------------------------------
	{
		return array(
			'tree' => array(
				'class' => 'DActiveRecordTreeBehavior',
				'idParent' => 'id_parent'),

			'select' => 'DActiveRecordSelectBehavior',	
			'image' => 'DImageBehavior',		  

		);
	}

	//----------------------------------------------------------------------------
	public function search()
	//----------------------------------------------------------------------------
	{
		// Внимание: удалите лишние атрибуты!

		$objCriteria = new CDbCriteria;

		// Запрос по параметрам
		$objCriteria->compare('id_parent', $this->id_parent, false);


		// Запрос по строке
		$objCriteria->compare('name', $this->request, true, 'OR');

		$objCriteria->order = 'flg_folder DESC, name ASC';

		return new CActiveDataProvider($this, array(
			'criteria' => $objCriteria,
			'pagination' => array('pageSize' => 30),
		));
	}


	public static function model($className=__CLASS__) {return parent::model($className);}
	public function tableName() {return 'tbl_files';}
}