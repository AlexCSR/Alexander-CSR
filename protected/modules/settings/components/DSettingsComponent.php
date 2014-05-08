<?php

# ver: 1.1.0

class DSettingsComponent extends CApplicationComponent
{
	public $config;
	private $_settingsEnum;

	private $_tabs = false;
	private $_model;

	//----------------------------------------------------------------------------	 
	public function getSettingsEnum()
	//----------------------------------------------------------------------------	 
	{
		if ($this->_settingsEnum === null) {
			$this->_settingsEnum = array();
			foreach ($this->config as $k => $v) {
				if (!is_array($v)) $this->_settingsEnum[$k] = $v;
				else {
					foreach ($v as $kk => $vv)
						$this->_settingsEnum[$kk] = $vv;
				}
			}
		}

		return $this->_settingsEnum;
	}

	//----------------------------------------------------------------------------	 
	public function init()
	//----------------------------------------------------------------------------	 
	{
		parent::init();
		// d($this->model);
		// $this->_model = new Settings;
	}

	//----------------------------------------------------------------------------	 
	public function getModel()
	//----------------------------------------------------------------------------	 
	{
		if ($this->_model === null) $this->_model = new Settings;
		return $this->_model;
	}

	//----------------------------------------------------------------------------	 
	public function __get($name)
	//----------------------------------------------------------------------------	 
	// Обращение к именованной настройке
	{		
		if (isset($this->_settingsEnum[$name])) return $this->model->$name;
		else return parent::__get($name);
	}

	//----------------------------------------------------------------------------	 
	public function getTabs()
	//----------------------------------------------------------------------------	 
	{
		$arrTabs = array();

		foreach ($this->config as $k => $v) {
			if (is_array($v)) {
				$this->_tabs = true;
				$arrTabs[$k] = $v;
			}
			else $arrTabs['Default'][$k] = $v;
		}

		return $arrTabs;
	}

	//----------------------------------------------------------------------------	 
	public function getHasTabs()
	//----------------------------------------------------------------------------	 
	{
		$this->getTabs();
		return $this->_tabs;
	}
}
