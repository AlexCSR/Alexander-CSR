<?php

# ver: 1.0.0.1

class DcController extends DController
{
	public $layout = '//layouts/cp';
  public $errorAction = 'cp/error';
  public $errorView = 'application.views.cp.error';

  protected $_menu;


  //----------------------------------------------------------------------------
  public function getIsMenuNull()
  //----------------------------------------------------------------------------  
  // Есть ли в меню хотя бы одна видимая ссылка (только для плоских меню)
  {
    foreach ($this->menu as $stt_menu)
      if (isset($stt_menu['url']) && (!isset($stt_menu['visible']) || $stt_menu['visible'] == true))
        return false;
    return true;
  }

  //----------------------------------------------------------------------------  
  public function getMenu()
  //----------------------------------------------------------------------------  
  {
    if ($this->_menu === null) $this->_menu = $this->initMenu();
    return $this->_menu;
  }

  //----------------------------------------------------------------------------  
  public function setMenu($stt_menu)
  //----------------------------------------------------------------------------  
  {
    if ($this->_menu === null) $this->_menu = $this->initMenu();    
    $this->_menu = $stt_menu;
  }
  
  //----------------------------------------------------------------------------  
  public function initMenu()
  //----------------------------------------------------------------------------  
  // Меню по умолчанию (для всех действий контроллера)
  {
    return array();
  }





}
