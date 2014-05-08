<?php

# ver: 1.0.0

class DPhpAuthManager extends CPhpAuthManager
{
	public $rolesFile;
	public $rightsFile;

	//---------------------------------------------------------------------------- 
	public function init()
	//----------------------------------------------------------------------------  
	{
		$this->authFile = Yii::getPathOfAlias('application.config.roles').'.php';
		$this->rolesFile = $this->authFile;    

		$this->rightsFile = Yii::getPathOfAlias('application.config.rights').'.php';

		parent::init(); // Загрузить информацию из файла ролей

		// Назначить роль текущему пользователю
		if(!Yii::app()->user->isGuest)
			$this->assign(Yii::app()->user->role, Yii::app()->user->id);
	}


	//----------------------------------------------------------------------------
	public function checkAccess($itemName, $userId, $params=array())
	//----------------------------------------------------------------------------
	{
		if (Yii::app()->user->role == 'root') return true; // Суперпользователю все можно!

		$arr_items = explode('/', $itemName);

		$str_full_item = '';
		foreach ($arr_items as $str_item)
		{
		  $str_full_item = $str_full_item . ($str_full_item != '' ? '/' : '') . $str_item;
		  if (parent::checkAccess($str_full_item, $userId, $params)) return true;
		}
		return false;
	}

	//----------------------------------------------------------------------------
	function loadRights()
	//----------------------------------------------------------------------------  
	{
		$arr_rights = require($this->rightsFile);

		foreach ($arr_rights as $str_role => $arr_tasks)
		  if (is_array($arr_tasks))
			$this->loadRightsR($str_role, $arr_tasks);
	}

	//----------------------------------------------------------------------------
	function loadRightsR($str_role, $arr_rights, $str_parent = '')
	//----------------------------------------------------------------------------  
	{
		// Перебрать потомков
		foreach ($arr_rights as $str_task => $arr_tasks)
		{
		  if (!is_array($arr_tasks)) $str_task = $arr_tasks;

		  // Создать задачу
		  $str_task = ($str_parent != '' ? $str_parent . '/' : '') . $str_task;
		  if ($this->getAuthItem($str_task) == null)
			$this->createAuthItem($str_task, CAuthItem::TYPE_TASK);

		  // Связать ее с предком
		  if ($str_parent != '')
			$this->addItemChild($str_parent, $str_task);
		  
		  // Если конец дерева, сделать присвоение для роли, иначе - дальше вниз
		  if (is_array($arr_tasks)) $this->loadRightsR($str_role, $arr_tasks, $str_task);
		  else $this->addItemChild($str_role, $str_task);
		}
	}

	//----------------------------------------------------------------------------    
	public function load()
	//----------------------------------------------------------------------------
	// Загрузка файла упрощенного формата
	{
		parent::load();
		$this->loadRights();
	} 

}

