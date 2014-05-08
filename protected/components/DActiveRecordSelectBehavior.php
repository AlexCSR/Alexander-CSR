<?php

# ver: 1.0.0.1

class DActiveRecordSelectBehavior extends CActiveRecordBehavior
{

	//----------------------------------------------------------------------------
	public function selectByPk($id, $data = 1)
	//----------------------------------------------------------------------------
	{
		$_SESSION[$this->sessionName][$id] = $data;
	}

	//----------------------------------------------------------------------------
	public function unselectByPk($id)
	//----------------------------------------------------------------------------
	{
		unset($_SESSION[$this->sessionName][$id]);
	}

	//----------------------------------------------------------------------------
	public function getSelectedPk()
	//----------------------------------------------------------------------------
	{
		if (!isset($_SESSION[$this->sessionName]))
			$_SESSION[$this->sessionName] = array();
		return array_keys($_SESSION[$this->sessionName]);
	}

	//----------------------------------------------------------------------------
	public function getSelected()
	//----------------------------------------------------------------------------
	{
		if (!isset($_SESSION[$this->sessionName]))
			$_SESSION[$this->sessionName] = array();
		return $_SESSION[$this->sessionName];
	}

	//----------------------------------------------------------------------------
	public function unselectAll()
	//----------------------------------------------------------------------------
	{
		$_SESSION[$this->sessionName] = array();
	}

	//----------------------------------------------------------------------------
	public function getHasSelection()
	//----------------------------------------------------------------------------
	{
		return (count($this->selectedPk) > 0);
	}	

	//----------------------------------------------------------------------------
	public function getIsSelected()
	//----------------------------------------------------------------------------
	{
		return isset($_SESSION[$this->sessionName][$this->owner->id]);
	}

	//----------------------------------------------------------------------------
	public function getSessionName()
	//----------------------------------------------------------------------------
	{
		return get_class($this->owner) . 'Select';
	}
}

