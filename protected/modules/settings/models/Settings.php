<?php

# ver: 1.1.0

class Settings extends CFormModel
{
	public $name;

	public $_values;
	public $path;

	//----------------------------------------------------------------------------	 
	public function init()
	//----------------------------------------------------------------------------	 
	{
		$this->path = Yii::getPathOfAlias('application.runtime') . '/settings.txt';
		$this->attributes = $this->loadValues();
	}

	//----------------------------------------------------------------------------	 
	public function loadValues()
	//----------------------------------------------------------------------------	 
	{
		if (!is_file($this->path) || !($arrSettings = unserialize(file_get_contents($this->path))))
		{
			$arrSettings = array_fill_keys($this->attributeNames(), '');
			file_put_contents($this->path, serialize($arrSettings));
		}
		return $arrSettings;
	}

	//----------------------------------------------------------------------------	 
	public function rules()
	//----------------------------------------------------------------------------	
	{
		return array(
			array(implode(', ', $this->attributeNames()), 'required'),
		);
	}

	//----------------------------------------------------------------------------  
	public function __set($name, $value)
	//----------------------------------------------------------------------------  
	{
		if (in_array($name, $this->attributeNames())) $this->_values[$name] = $value;
		else parent::__set($name, $value);
	}

	//----------------------------------------------------------------------------  
	public function __get($name)
	//----------------------------------------------------------------------------  
	{
		if (in_array($name, $this->attributeNames())) {
			return isset($this->_values[$name]) ? $this->_values[$name] : '';
		} 
		else return parent::__get($name);		
	}

	//----------------------------------------------------------------------------  
	public function attributeNames()
	//----------------------------------------------------------------------------
	{
		return array_keys(Yii::app()->settings->settingsEnum);
	}


	//----------------------------------------------------------------------------  
	public function attributeLabels()
	//----------------------------------------------------------------------------  
	{
		return Yii::app()->settings->settingsEnum;
	}


	//----------------------------------------------------------------------------  
	public function save($runValidation=true,$attributes=null)
	//----------------------------------------------------------------------------  
	{
		if($this->validate($attributes))
			return file_put_contents($this->path, serialize($this->attributes));
		else return false;
	}	
}
