<?php

# ver: 1.0.0
# req: components/BackuperArchiveZip.php 1.0
# req: components/BackuperExecDumper.php 1.0
# req: components/BackuperPhpDumper.php 1.0
# req: controllers/BackupController.php

Yii::setPathOfAlias('var', Yii::app()->basePath . '/../var/');

class BackuperModule extends CWebModule
{
	public $serverName;                           // Код сервера (LCH или SRV) 
	public $dumperClass = 'BackuperExecDumper';   // Используемый бекапер (на PHP или на mysqldump)
	private $_enumTables;

	//----------------------------------------------------------------------------
	public function getEnumTables()
	//----------------------------------------------------------------------------
	{
		if ($this->_enumTables === null) {
			$this->_enumTables = array();
			$dr = Yii::app()->db->createCommand('SHOW TABLES')->query();
			
			while ($t = $dr->read())
			{
				$str_table = array_pop($t);
				$this->_enumTables[] = $str_table;
			}   
		}
		return $this->_enumTables;
	}

	//----------------------------------------------------------------------------
	public function init()
	//----------------------------------------------------------------------------
	{
		// import the module-level models and components
		$this->setImport(array(
			'backuper.models.*',
			'backuper.components.*',
		));
	}


}
