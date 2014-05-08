<?php

# ver: 1.1.0.1

class DActiveRecordSortBehavior extends CActiveRecordBehavior
{
	public $idParent; 				// Если используется конфигуратор
	public $order = 'id_sort';    	// Поле сортировки (только по возрастанию)


	//----------------------------------------------------------------------------
	public function beforeSave($event)
	//----------------------------------------------------------------------------  
	// После вставки запись стала последней 
	{
		if ($this->owner->isNewRecord)
		{
			$dr = Yii::app()->db->createCommand()
			->select('MAX(' . $this->order . ')')
			->from($this->owner->tableName());

			if ($this->idParent !== null)  
				$dr->where($this->idParent . ' = ' . $this->owner->attributes[$this->idParent]);

			$intMaxOrder = $dr->queryScalar();
			$strOrder = $this->order;

			$this->owner->$strOrder = $intMaxOrder + 2;
		}

	}

	//----------------------------------------------------------------------------
	public function incSort()
	//----------------------------------------------------------------------------	
	{
		$strOrder = $this->order;
		$this->owner->$strOrder -= 3;
		$this->owner->save();
		$this->owner->_correctTable();
	}

	//----------------------------------------------------------------------------
	public function decSort()
	//----------------------------------------------------------------------------
	{
		$strOrder = $this->order;
		$this->owner->$strOrder += 3;
		$this->owner->save();
		$this->owner->_correctTable();
	}

	//----------------------------------------------------------------------------
	public function _correctTable()
	//----------------------------------------------------------------------------	
	{
		Yii::app()->db->createCommand('set @a:=0')->execute();


		$strWhere = ($this->idParent !== null) ? ' WHERE `' . $this->idParent . '` = ' . $this->owner->attributes[$this->idParent] : '';
		$cmd = Yii::app()->db->createCommand('UPDATE `' . $this->owner->tableName() . '` ' .
									  'SET ' . $this->order . ' = (@a:=@a+2) ' . 
									  $strWhere . 
									  ' ORDER BY `' . $this->order . '`');
		$cmd->execute();
	}
}