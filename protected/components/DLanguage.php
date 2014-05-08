<?php

class DLanguage extends CComponent
{

	//----------------------------------------------------------------------------  
	public function getLanguage()
	//----------------------------------------------------------------------------  
	{
		$ret = '';
		if (!isset(Yii::app()->request->cookies['interface_language'])) {
			$ret = Yii::app()->sourceLanguage;
		} 
		else $ret = Yii::app()->request->cookies['interface_language']->value;

		return $ret;
	}

	//----------------------------------------------------------------------------  
	public function setLanguage($val)
	//----------------------------------------------------------------------------  
	{
		if (in_array($val, array('en', 'ru'))) {
			Yii::app()->request->cookies['interface_language'] = new CHttpCookie('interface_language', $val, array('expire' => strtotime('+ 1 year')));
			Yii::app()->language = $val;
		}
	}

	//----------------------------------------------------------------------------  
	public function initLanguage()
	//----------------------------------------------------------------------------  
	{
		$this->setLanguage($this->getLanguage());		
	}

}