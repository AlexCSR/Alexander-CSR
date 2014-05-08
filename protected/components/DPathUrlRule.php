<?php

# ver: 1.0.0

//*****************************************************************************
class DPathUrlRule extends CBaseUrlRule
//*****************************************************************************
// Правило для передачи путей, разделенных слешами, в УРЛе
{

	public $route;
	public $pattern;	// Шаблон без указания того, что в конце будет путь

	public $pathVar = 'path';	// Переменная, в которой сохранится путь
	public $pathPattern = '<path:.+>';

	//----------------------------------------------------------------------------
	public function createUrl($manager, $route, $params, $ampersand)
	//----------------------------------------------------------------------------
	{
		if (!isset($params[$this->pathVar])) return false;

		// Обработать путь, удалить его из параметров
		$arrRoute = explode('/', $params[$this->pathVar]);
		foreach ($arrRoute as $k => $v) $arrRoute[$k] = urlencode($v);
		$strRoute = implode('/', $arrRoute);		

		// Удалить путь из параметров
		unset($params[$this->pathVar]);

		// Подставить путь в паттерн и отдать обычному правилу
		$objUrlRule = New CUrlRule($route, $this->pattern . '/' . $strRoute);		
		return $objUrlRule->createUrl($manager, $route, $params, $ampersand);
	}



	//----------------------------------------------------------------------------
	public function parseUrl($manager, $request, $pathInfo, $rawPathInfo)
	//----------------------------------------------------------------------------
	{
		$strPattern = $this->pattern . ($this->pattern == '' ? '' : '/') . $this->pathPattern; 
		$objUrlRule = New CUrlRule($this->route, $strPattern);		
		$sttUrl = $objUrlRule->parseUrl($manager, $request, $pathInfo, $rawPathInfo);
		return $sttUrl;
	}

}


?>