<?php

// alias: modules.users.components.DWebUser
// version: 1.1.0
// dependencies:
// modules.users.models.User 1.1
// enddep

class DTestUser extends CWebUser 
{
	private $_model = null;

	public $id = 1;
	
	//----------------------------------------------------------------------------  
	public function init()
	//----------------------------------------------------------------------------  
	{
		parent::init();

		if (!$this->isGuest && $this->model === null) $this->logout();


		if (!$this->isGuest && $this->model->tst_last_auth < strtotime('today'))
		{
			$this->model->tst_last_auth = time();
			$this->model->cnt_auth++;
			$this->model->save();
		}
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