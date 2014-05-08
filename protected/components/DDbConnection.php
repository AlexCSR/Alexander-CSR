<?php

# ver: 1.0.0

//******************************************************************************
class DDbConnection extends CDbConnection
//******************************************************************************
// Обертка нужна для получения параметров доступа к базе:
// Yii::app()->db->username 
// Yii::app()->db->password
// Yii::app()->db->database
// Yii::app()->db->host
{
	public $_host = 'localhost';
	public $_database;
	

  //----------------------------------------------------------------------------
  public function setDatabase($value)
  //----------------------------------------------------------------------------
  {
    $this->_database = $value;
    $this->initConnectionString();
  }  

  //----------------------------------------------------------------------------
  public function setHost($value)
  //----------------------------------------------------------------------------
  {
    $this->_host = $value;
    $this->initConnectionString();
  }  

  //----------------------------------------------------------------------------
  public function getHost()
  //----------------------------------------------------------------------------
  {
    return $this->_host;
  } 

  //----------------------------------------------------------------------------
  public function getDatabase()
  //----------------------------------------------------------------------------
  {
    return $this->_database;
  }  
  

  //----------------------------------------------------------------------------
  private function initConnectionString()
  //----------------------------------------------------------------------------  
  {
    if ($this->_host !== null && $this->_database !== null)
      $this->connectionString = 'mysql:host=' . $this->_host . ';dbname=' . $this->_database;  
  }
}
