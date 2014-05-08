<?php

# ver: 1.1.1

class DActiveRecordTreeBehavior extends CActiveRecordBehavior
{
	public $idParent = 'id_parent';

	private $_parents;
	private $_children;
	private $_allChildren;

	public $_img;
	public $_storage;

	protected $id_level;

	//----------------------------------------------------------------------------
	public function getImg()
	//----------------------------------------------------------------------------
	{
		return $this->hasImage ? $this->_storage->_img : null;
	}

	//----------------------------------------------------------------------------
	public function getHasImage()
	//----------------------------------------------------------------------------
	{
		return isset($this->_storage->_img) && $this->_storage->_img != null;
	}

	//----------------------------------------------------------------------------
	public function withImage($condition='', $params=array())
	//----------------------------------------------------------------------------
	// Загружает
	{
		if (!$this->hasImage) {

			// Запрашивает данные
			$arr = $this->owner->findAll($condition, $params);

			// Настраивает объект
			$this->_storage = $this;
			$this->_img = array();

			// Передает в элементы образа сведения о себе
			foreach ($arr as $modItem) {
				$modItem->_storage = $this;
				$this->_img[$modItem->id] = $modItem;
			}
		}

		return $this->owner;
	}

	//----------------------------------------------------------------------------
	public function beforeDelete($event)
	//----------------------------------------------------------------------------  
	// Удалить всех потомков, в событии сохранить ключи удаленных узлов
	{
		foreach ($this->withImage()->children as $modChild)
			$modChild->delete();
	}

	//----------------------------------------------------------------------------
	public function buildFlatTree()
	//----------------------------------------------------------------------------
	{
		if (!$this->hasImage) $this->withImage();
		return $this->buildFlatTreeR();		
	}

	//----------------------------------------------------------------------------
	public function buildFlatTreeR($id_parent = 0, $id_level = 0)
	//----------------------------------------------------------------------------
	{
		$arrRet = array();

		foreach ($this->img as $modItem) {
			if ($modItem->getParentId() == $id_parent) {
				$modItem->id_level = $id_level;
				$arrRet[] = $modItem;
				$arrRet = array_merge($arrRet, $this->buildFlatTreeR($modItem->id, $id_level + 1));
			}
		}	

		return $arrRet;
	}

	//----------------------------------------------------------------------------
	public function getParentId()
	//----------------------------------------------------------------------------
	{
		return $this->owner[$this->idParent];
	}

	//----------------------------------------------------------------------------
	public function getLevelId()
	//----------------------------------------------------------------------------
	{
		return $this->id_level;		
	}

	//----------------------------------------------------------------------------
	public function getChildren()
	//----------------------------------------------------------------------------
	// Прямые потомки
	{		
		if($this->_children == null) {
			$id = $this->owner->id == null ? 0 : $this->owner->id;


			if ($this->hasImage) {



				$this->_children = array();
				foreach ($this->img as $k => $v)
					if ($v[$this->idParent] == $id)
						$this->_children[] = $v;

			} else $this->_children = $this->owner->findAllByAttributes(array($this->idParent => $id));
		}

		return $this->_children;
	}


	//----------------------------------------------------------------------------
	public function getParents()
	//----------------------------------------------------------------------------
	// Прямые потомки
	{		
		if($this->_parents == null) {
			$this->_parents = array();

			$id_parent = $this->owner[$this->idParent];

			while ($id_parent != 0) {
				foreach ($this->withImage()->img as $k => $v) {
					if ($v->id == $id_parent) {
						$this->_parents[] = $v;
						$id_parent = $v[$this->idParent];
						break;
					}
				}				
			}

			$this->_parents = array_reverse($this->_parents);
		}

		return $this->_parents;
	}

	//----------------------------------------------------------------------------
	public function getAllChildren()
	//----------------------------------------------------------------------------
	// Возвращает всех потомков
	{
		if ($this->_allChildren == null) {
			$this->_allChildren = array();
			foreach ($this->withImage()->children as $modChild) {
				$this->_allChildren[] = $modChild;
				$this->_allChildren = array_merge($this->_allChildren, $modChild->allChildren);
			}
		}

		return $this->_allChildren;
	}

}

