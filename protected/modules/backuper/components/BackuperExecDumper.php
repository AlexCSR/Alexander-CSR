<?php

# ver: 1.0.0

class BackuperExecDumper
{
	public $error;

	//----------------------------------------------------------------------------  
	public function dump($arrTables, $strFile)
	//----------------------------------------------------------------------------  
	{
		$strTables = implode(' ', $arrTables);
		exec('mysqldump -u' . Yii::app()->db->username . ' --password=' . Yii::app()->db->password . ' ' . Yii::app()->db->database . ' ' . $strTables . ' > ' . $strFile);
		return 0;
	}

	//----------------------------------------------------------------------------
	public function retreive($strFile)
	//----------------------------------------------------------------------------  
	{
		$str = 'mysql -u' . Yii::app()->db->username . ' --password=' . Yii::app()->db->password . ' ' . Yii::app()->db->database . ' < ' . $strFile . ' 2>&1';

		$o = $r = null;
		$str = exec($str, $o, $r);
		if ($r == 1) $this->error = $str;
		return $r == 0 ? true : false;
	}

}

?>