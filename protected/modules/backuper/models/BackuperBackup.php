<?php

# ver: 1.0.0
# req: /protected/modules/backuper/components/BackuperArchiveZip.php 1.0
# req: /protected/modules/backuper/components/BackuperExecDumper.php 1.0
# req: /protected/modules/backuper/components/BackuperPhpDumper.php 1.0

//----------------------------------------------------------------------------  
function rm_dir_r($dir_name)
//----------------------------------------------------------------------------  
{
	if (is_dir($dir_name) === false) return;
	$hdl_dir = opendir($dir_name);
	while(($file = readdir($hdl_dir)) !== false) 
	{
		if ($file != '.' && $file != '..')
		{
			$file_name = $dir_name . '/' . $file;
			if (is_dir($file_name)) rm_dir_r($file_name);
			else unlink($file_name);
		}
	}
	closedir($hdl_dir);
	rmdir($dir_name);
}  

//******************************************************************************
class BackuperBackup extends CFormModel
//******************************************************************************
{
	private $_baseDir;

	private $_objArchive;
	private $_objDumper;

	// Свойства
	public $id;
	public $name = 'Резервная копия';
	public $url_type;
	public $date;
	public $server_name;
	public $user;
	public $tables;
	public $error;
	
	private $_enumTables;
	public $enum_url_type = array('SMP' => 'SMP - Simple', 'MOV' => 'MOV - Для передачи');

	//----------------------------------------------------------------------------
	public function init()
	//----------------------------------------------------------------------------
	{
		$this->_baseDir = Yii::getPathOfAlias('application.data');

		$strDumperClass = Yii::app()->controller->module->dumperClass;

		$this->_objArchive = new BackuperArchiveZip;   // Архиватор
		$this->_objDumper = new $strDumperClass;    // Дампер
		
		
		$this->user = Yii::app()->user->name;
		$this->date = time();
		$this->tables = $this->getEnumTables();
	}

	//----------------------------------------------------------------------------
	public function getEnumTables()
	//----------------------------------------------------------------------------  
	{
		return Yii::app()->getModule("backuper")->enumTables;
	}

	//----------------------------------------------------------------------------
	public function attributeLabels()
	//----------------------------------------------------------------------------  
	{
		return array('name' => 'Имя', 
					 'tables' => 'Таблицы', 
					 'server_name' => 'Сервер', 
					 'url_type' => 'Тип бекапа',
					 'date' => 'Время создания',
					 'user' => 'Создатель');
	}

	//----------------------------------------------------------------------------
	public function attributeNames()
	//----------------------------------------------------------------------------  
	{
		return array('id', 'name', 'date', 'server_name', 'user', 'tables');
	}

	//----------------------------------------------------------------------------
	public function attributeInputs()
	//----------------------------------------------------------------------------  
	{
		return array('name' => 'textField',

								 'url_type' => array(
									 'type' => 'dropDownList',
									 'data' => array('SMP' => 'SMP - Simple', 'MOV' => 'MOV - Для передачи')),                    

								 'tables' => array(
									 'type' => 'checkBoxList',
									 'data' => array_combine($this->enumTables, $this->enumTables)),                    

									 );
	}

	//----------------------------------------------------------------------------
	public function rules()
	//----------------------------------------------------------------------------  
	{
		return array(
						array('name', 'required'),
						array('url_type, date, server_name, user, tables', 'safe'),
					);
	}

	//----------------------------------------------------------------------------
	public function save()
	//----------------------------------------------------------------------------  
	{
		$sttBackup = $this->attributes;
		unset($sttBackup['id']);
		$this->id = $this->server_name . '-' . $this->getNewNumber() . '-' . $this->url_type;
		$str_arch_dir = $this->_baseDir . '/' . $this->id . '/';
		mkdir($str_arch_dir);
		$this->_objDumper->dump($this->tables, $str_arch_dir . 'dump.sql');
		file_put_contents($str_arch_dir . 'backup.bnf', serialize($sttBackup));
		$this->_objArchive->pack($str_arch_dir, array('backup.bnf', 'dump.sql'), $this->_baseDir . '/' . $this->id .  '.zip');		
		rm_dir_r($str_arch_dir);
		return true;
	}

	//----------------------------------------------------------------------------
	public function deleteByPk($urlBackup)
	//----------------------------------------------------------------------------  
	{
		if ($this->findByPk($urlBackup) == null) return false;
		else return unlink($this->_baseDir . '/' . $urlBackup . '.zip');
	}

	//----------------------------------------------------------------------------
	public function retreiveByPk($urlBackup)
	//----------------------------------------------------------------------------  
	{
		$strDir = $this->_baseDir . '/' . $urlBackup;
		$strFile = $this->_baseDir . '/' . $urlBackup . '.zip';


		if (is_file($strFile))
		{
			if (is_dir($strDir)) rm_dir_r($strDir);
			mkdir($strDir);
			$this->_objArchive->unpack($strFile, $strDir, 'dump.sql');

			$flgRet = true;
			if (!$this->_objDumper->retreive($strDir . '/dump.sql')) {
				$this->error = $this->_objDumper->error;
				$flgRet = false;
			}

			
			rm_dir_r($strDir);      
			return $flgRet;
		}
		else return false;    
	}

	//----------------------------------------------------------------------------
	public function findAll()
	//----------------------------------------------------------------------------  
	{
		$arrBackups = array();
		$hdlDir = opendir($this->_baseDir);
		
		while(($strFile = readdir($hdlDir)) !== false) 
		{
			$urlBackup = substr($strFile, 0, -4);
			$modBackup = $this->findByPk($urlBackup);
			if ($modBackup !== null) $arrBackups[$urlBackup] = $modBackup;
		}  
		krsort($arrBackups);
		return array_values($arrBackups);
	}

	//----------------------------------------------------------------------------
	public function findByPk($urlBackup)
	//----------------------------------------------------------------------------
	{     
		$strFile = $this->_baseDir . '/' . $urlBackup . '.zip';

		if (is_file($strFile) && $ssttFile = $this->_objArchive->read($strFile, 'backup.bnf'))
		{
			$modBackup = new BackuperBackup;
			$modBackup->id = $urlBackup;
			$modBackup->attributes = unserialize($ssttFile);
			return $modBackup;
		}
		else return null;
	}
	
	//----------------------------------------------------------------------------
	public function getNewNumber()
	//----------------------------------------------------------------------------  
	// Очередной трехзначный номер в проекте
	{
		$hdlDir = opendir($this->_baseDir);
		$arr_sort = array();
		while(($file = readdir($hdlDir)) !== false)
			if (substr($file, -4, 4) == '.zip') 
				$arr_sort[] = (int)substr($file, 4, 3);

		if (count($arr_sort) == 0) return '001';
		else return sprintf('%03d', (max($arr_sort) + 1));
	}  
}


?>
