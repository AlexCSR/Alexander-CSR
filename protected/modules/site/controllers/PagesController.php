<?php
# ver: 1.0.p.0
# com: Добавлены свойства showSlider и showNews


Yii::import('application.modules.pages.models.*');

class PagesController extends DsController
{
	public $idCurrent;
	public $urlCurrentFirst;
	public $searchPage;

	//----------------------------------------------------------------------------
	public function actionView($path)
	//----------------------------------------------------------------------------
	{
		$modPage = $this->loadModel($path);

		$this->breadcrumbs = $this->breadcrumbs + $modPage->breadcrumbs;
		$this->pageTitle = $modPage->getTitle();
	

		foreach ($modPage->parents as $modParent) {
				if (Yii::app()->user->isGuest && $modParent->alias == 'additional') {
					$this->accessDenied();	
			} 
		}

		// Сформировать данные
		$arrData = array('modPage' => $modPage, 'template' => $modPage->template);
		
		$strTemplate = $modPage->template;

		// Автоматически определить шаблон
		if ($modPage->template == '[default]')
		{
			if($modPage->isFolder) $strTemplate = 'viewFolder'; // $this->render('viewFolder', $arrData);
			else $strTemplate = 'viewPage'; 					// $this->render('view', $arrData);
		} 

		$this->showNews = $modPage->showNews;
		$this->showSlider = $modPage->showSlider;

		unset($this->breadcrumbs['Главная']);

		$this->idCurrent = $modPage->id;
		$this->render($strTemplate, array('modPage' => $modPage));
	}

	//----------------------------------------------------------------------------
	public function actionSearch()
	//----------------------------------------------------------------------------
	{
		$this->pageTitle = Yii::t('site', 'Поиск по сайту');

		$modPage = new Page('search');
		$modPage->unsetAttributes();
		
		if(isset($_GET['Page'])) $modPage->attributes = $_GET['Page'];

		$this->searchPage = $modPage;

		$this->render('search', array('modPage' => $modPage));
	}

	//----------------------------------------------------------------------------
	public function loadModel($strPath)
	//----------------------------------------------------------------------------
	{
		$modPage = Page::model()->withImage(array('order' => 'id_sort DESC'))->findByRoute($strPath);

		if($modPage === null || !$modPage->isPublished)
			throw new CHttpException(404, 'Запрошенная страница не найдена');

		$modPage->publishAssets();

		return $modPage;
	}
}