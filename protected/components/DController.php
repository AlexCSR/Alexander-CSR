<?php

# ver: 1.0.1

class DController extends CController
{
	// Действие по умолчанию
	public $defaultAction = 'list'; 
	public $defaultActionName = null;
	
	// Хлебные крошки
	public $breadcrumbsPrefix = array();
	public $breadcrumbs = array();

	// Обработка ошибок
	public $errorView = 'application.modules.site.views.site.error';
	public $errorAction;

	// Показывать ли заголовок в лейауте
	public $showTitle = true;

	public function init()
	{
	if ($this->errorAction !== null) Yii::app()->errorHandler->errorAction = $this->errorAction;
	}

	//----------------------------------------------------------------------------
	public function actionError()
	//----------------------------------------------------------------------------
	// Обработка ошибки 
	{
		$this->breadcrumbs = array();
		$this->pageTitle = 'Ой...';
		if($error=Yii::app()->errorHandler->error)
		{
		if(Yii::app()->request->isAjaxRequest)
			echo $error['message'];
		else
			$this->render($this->errorView, $error);
		}
	}

	
	//----------------------------------------------------------------------------  
	public function filters()
	//----------------------------------------------------------------------------	
	{
		return array('rights');
	}

	//----------------------------------------------------------------------------
	public function filterRights($filterChain)
	//----------------------------------------------------------------------------  
	{
	if (Yii::app()->user->checkAccess($this->route)) $filterChain->run();
	else $this->accessDenied();
	}

	//----------------------------------------------------------------------------
	public function accessDenied($message=null)
	//----------------------------------------------------------------------------	
	{
		if($message === null)
			$message = 'Недостаточно прав для выполнения действия';

		$user = Yii::app()->getUser();
		if($user->isGuest === true) $user->loginRequired();
		else throw new CHttpException(404, $message);
	}

	//----------------------------------------------------------------------------
	protected function beforeAction($action)
	//----------------------------------------------------------------------------  
	{
		$this->resetBreadcrumbs(); // Настроить хлебные крошки по умолчанию
		return true;
	}

	//----------------------------------------------------------------------------
	public function resetBreadcrumbs()
	//----------------------------------------------------------------------------  
	// Текущие хлебные крошки
	{
		// Это если контроллер стоит не сразу после главной в иерархии сайта
		$this->breadcrumbs = $this->breadcrumbsPrefix;

		// Хлебные крошки если есть действие по умолчанию
		$obj_def_action = $this->createAction($this->defaultAction);
		if ($obj_def_action !== null)
		{
			// Определить имя действия по умолчанию
			if ($this->defaultActionName != null) $str_def_action_name = $this->defaultActionName;
			else $str_def_action_name = isset($obj_def_action->name) ? $obj_def_action->name : $obj_def_action->id;
		
			// Если выполняется не действие по умолчанию, то в крошки надо добавить
			// ссылку на него 
			if ($this->action->id != $this->defaultAction)
			$this->breadcrumbs[$str_def_action_name] = $this->createUrl($this->defaultAction);
			
			else $this->pageTitle = $str_def_action_name;
		}
	}

	//----------------------------------------------------------------------------
	function missingAction($actionID)
	//----------------------------------------------------------------------------  
	{
		throw new CHttpException(404, 'Действие не определено и не может быть выполнено.');
	}

	//----------------------------------------------------------------------------  
	public function initPageStatePrevious($default = null)
	//----------------------------------------------------------------------------  
	{
		if ($default === null) $default = $this->createUrl($this->defaultAction); 
		$this->setPageState('previousUrl', Yii::app()->request->urlReferrer === null ? $default : Yii::app()->request->urlReferrer);
	}

	//----------------------------------------------------------------------------  
	public function getPageStatePrevious()
	//----------------------------------------------------------------------------  
	{
		return $this->getPageState('previousUrl', null);
	}

	//----------------------------------------------------------------------------  
	public function redirectPageStatePrevious()
	//----------------------------------------------------------------------------  
	{
		$this->disableLogs();
		$this->redirect($this->pageStatePrevious);
	}

	//----------------------------------------------------------------------------  
	public function redirectDefault()
	//----------------------------------------------------------------------------  
	{
		$this->disableLogs();
		$this->redirect($this->createUrl($this->defaultAction));
	}

	//----------------------------------------------------------------------------  
	public function redirectBack()
	//----------------------------------------------------------------------------  
	{
		$this->disableLogs();
		$this->redirect(Yii::app()->request->urlReferrer);
	}

	//----------------------------------------------------------------------------  
	public function disableLogs()
	//----------------------------------------------------------------------------  
	// Доступно с версии 1.0.1
	{
		foreach (Yii::app()->log->routes as $route)
			if ($route instanceof CWebLogRoute)
				$route->enabled = false;
	}
}
