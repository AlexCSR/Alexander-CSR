<?php

# ver: 1.0.0

class BackuperPhpDumper
{
	private $_hFile;
	public $error;

	//----------------------------------------------------------------------------  
	public function dump($arrTables, $strFile)
	//----------------------------------------------------------------------------  
	{
		$this->_hFile = fopen($strFile, 'a');
		 
		foreach ($arrTables as $strTable) 
		{
			$this->_tableStructure($strTable);
			$this->_tableData($strTable);
			$this->push("\n\n");
		}
		
		fclose($this->_hFile);
		return 0;
	}

	//----------------------------------------------------------------------------
	public function retreive($strFile)
	//----------------------------------------------------------------------------  
	{
		$lnk = mysql_connect(Yii::app()->db->host, Yii::app()->db->username, Yii::app()->db->password);

		mysql_select_db(Yii::app()->db->database, $lnk);
		mysql_query('SET NAMES UTF8', $lnk);
		
		$str = $this->query_parser(file_get_contents($strFile));
		foreach($str as $item) 
			if(!mysql_query($item, $lnk))
				die("Invalid query: " . mysql_error());

		return true;
	}

	//----------------------------------------------------------------------------  
	private function _tableStructure($table)
	//----------------------------------------------------------------------------  
	// Структура таблицы
	{
		$arrStructure = Yii::app()->db->createCommand('SHOW CREATE TABLE ' . $table)->queryRow();    
		$this->push('/* Table structure for table `' . $table . '` */'. "\n");
		$this->push("DROP TABLE IF EXISTS `$table`;\n");
		$this->push($arrStructure['Create Table'] . ";\n\n");	
	}
	
	//----------------------------------------------------------------------------
	private function _tableData($strTable)
	//----------------------------------------------------------------------------
	{
		$this->push("/* Dumping data for table `$strTable` */\n");

		$drData = Yii::app()->db->createCommand('SELECT * FROM ' . $strTable)->query();
		if($drData->rowCount > 0)
		{
			$strInsert = "INSERT INTO `$strTable` VALUES ";

			$arrRows = array();
			foreach ($drData as $row) // while( $row= mysql_fetch_row($result))
			{
				$sttRow = array();
				foreach ($row as $cell)
					$sttRow[] = (is_null($cell) ? 'null' : '"' . addslashes($cell) . '"'); 
				$this->push($strInsert . ' (' . implode(', ', $sttRow) . ');' . "\n");
			}
		}
	}

	//----------------------------------------------------------------------------  
	function query_parser($q)
	//----------------------------------------------------------------------------  
	{
		 // strip the comments from the query
		 while($n=strpos($q,'--')){
				 $k=@strpos($q,"\n",$n+1);
				 if(!$k) $k=strlen($q);
				 $q=substr($q,0,$n).substr($q,$k+1);
		 }
	
	
		 $n=strlen($q);
		 $k=0;
		 $queries=array();
		 $current_delimiter='';
	
		 for($i=0;$i<$n;$i++){
				 // if this slash escapes something,
				 // current delimiter must not be affected
				 if($q[$i]=='\\' &&
				 ($q[$i+1]=='\\' || $q[$i+1]=="'" || $q[$i+1]=='"')
				 ){
								 $queries[$k].=$q[$i].$q[$i+1];
								 $i++;
				 }
				 else{
	
						 if($q[$i]==$current_delimiter)
								 $current_delimiter='';
						 elseif($q[$i]=='`' || $q[$i]=="'" || $q[$i]=='"')
								 $current_delimiter=$q[$i];
	
						 if($q[$i]==';' && $current_delimiter==''){
								 $queries[$k]=trim($queries[$k]);
								 if(trim(substr($q,$i),"\r \n;")!='')
										 $k++;
						 }
						 else
								 @$queries[$k].=$q[$i];
	
				 }
		 }
		 return $queries;
	}
	
	//----------------------------------------------------------------------------
	private function push($strData)
	//----------------------------------------------------------------------------
	{
		fwrite($this->_hFile, $strData);
	}
}

?>