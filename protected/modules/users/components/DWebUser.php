<?php

# ver: 1.2.0

class DWebUser extends CWebUser 
{
	private $_model = null;


	//----------------------------------------------------------------------------  
	public function init()
	//----------------------------------------------------------------------------  
	{
		parent::init();

		if (!$this->isGuest && $this->model === null) $this->logout();
	}

	//----------------------------------------------------------------------------  
	public function getRole() 
	//----------------------------------------------------------------------------  
	{
		return $this->model !== null ? $this->model->url_role : null;
	}
	
	//----------------------------------------------------------------------------  
	public function getModel()
	//----------------------------------------------------------------------------
	{    
		if (!$this->isGuest && $this->_model === null)
			$this->_model = User::model()->findByPk($this->id);

		return $this->_model;
	}
}