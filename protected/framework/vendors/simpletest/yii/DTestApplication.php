<?php 

define('SIMPLETEST_DIR', dirname(__FILE__) . '/../simpletest/');

require_once SIMPLETEST_DIR . 'web_tester.php';
require_once SIMPLETEST_DIR . 'reporter.php';
require_once SIMPLETEST_DIR . 'unit_tester.php';
require_once SIMPLETEST_DIR . 'mock_objects.php'; 

class DTestApplication extends CWebApplication
{

	private $obj_test;

	public $tests = array();

	//----------------------------------------------------------------------------
	private function addTestFiles()
	//----------------------------------------------------------------------------
	// Подключает тесты в соответствии с конфигом
	{
		foreach ($this->tests as $str)
		{
			$strTest = substr($str, strripos($str, '.') + 1);
			$strDir = substr($str, 0, strripos($str, '.'));

			if ($strTest == '*')
			{
				$hdlDir = opendir(Yii::getPathOfAlias('application.tests.' . $strDir));
			    while(($file = readdir($hdlDir)) !== false)
			    	if ($file != '.' && $file != '..')
						$this->obj_test->addTestFile(Yii::getPathOfAlias('application.tests.' . $strDir) . '/' . $file);
			}
			else 
			{
				$strTestFile = ucfirst($strTest) . '.php';
				$this->obj_test->addTestFile(Yii::getPathOfAlias('application.tests.' . $strDir) . '/' . $strTestFile);
			}
		}
	}

	//----------------------------------------------------------------------------
	public function fixDatabase()
	//----------------------------------------------------------------------------
	// Копирует структуру таблиц старой базы в новую
	{
	    // Соединиться с рабочей базой
	    $arrDlpSettings = require(Yii::getPathOfAlias('application.config') . '/main_local.php');
	    $sttDbSettings = $arrDlpSettings['components']['db'];
		$dbDst = new CDbConnection('mysql:host=localhost;dbname=' . $sttDbSettings['database'], $sttDbSettings['username'], $sttDbSettings['password']);

		// Удалить существующие тестовые таблицы
		$arrTestTables = Yii::app()->db->createCommand('SHOW TABLES')->queryColumn();
		foreach ($arrTestTables as $strTable)
			$arrCreateTables[] = Yii::app()->db->createCommand('DROP TABLE IF EXISTS `' . $strTable . '`')->execute();



		// Запросить рабочие таблицы
		$arrDstTables = $dbDst->createCommand('SHOW TABLES')->queryColumn();
		$arrCreateTables = array();
		foreach ($arrDstTables as $strTable)
			$arrCreateTables[] = $dbDst->createCommand('SHOW CREATE TABLE `' . $strTable . '`')->queryRow();

		// Записать в тестовую базу новые таблицы
		foreach ($arrCreateTables as $sttCreate) 
			//d($sttCreate['Create Table']);
			Yii::app()->db->createCommand($sttCreate['Create Table'])->execute();
	}

	//----------------------------------------------------------------------------
	public function processRequest()
	//----------------------------------------------------------------------------
	// Запускает приложение в тестах
	{
		$this->fixDatabase();	// Перебросить структуру базы данных

	    $this->obj_test = new GroupTest('Модульное тестирование');   
	    $this->addTestFiles();
	    
	    if (SimpleReporter::inCli()) exit ($this->obj_test->run(new TextReporter()) ? 0 : 1);
	    $this->obj_test->run(new HtmlReporter('UTF-8'));
	}

}

 ?>