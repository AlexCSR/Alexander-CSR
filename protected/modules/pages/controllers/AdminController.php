<?php

# ver: 1.1.p.1.1
# com: Изменения для отработки главной страницы


class AdminController extends DcController
{

	public $defaultAction = 'admin';

	//****************************************************************************
	// Работа с сортировкой
	//****************************************************************************
	// В действиях названия не перепутаны. Просто страницы сортируются
	// по убыванию id_sort. Новые страницы должны появляться сверху списка.

	//----------------------------------------------------------------------------
	public function actionMoveUp($id)
	//----------------------------------------------------------------------------  
	{
		$this->loadModel($id)->decSort();
		$this->redirectBack();
	}

	//----------------------------------------------------------------------------
	public function actionMoveDown($id)
	//----------------------------------------------------------------------------  
	{
		$this->loadModel($id)->incSort();
		$this->redirectBack();
	}

	//****************************************************************************
	// CRUD
	//****************************************************************************

	//----------------------------------------------------------------------------
	public function actionAdmin($id_parent = 0)
	//----------------------------------------------------------------------------
	{
		$modPage = $id_parent == 0 ? new Page : $this->loadModel($id_parent);

		$this->pageTitle = 'Страницы';
		

		if ($id_parent != 0)
		{
			$this->pageTitle = $modPage->title;
			foreach ($modPage->parents as $modParent) {
				$this->breadcrumbs[$modParent->title] = array('/pages/admin/admin', 'id_parent' => $modParent->id);
			}
		} else unset($this->breadcrumbs);

		$this->menu = array(                          
							array('label' => 'Опции'), 
							array('label' => 'Новая страница', 
										'icon' => 'plus',
										'url' => array('/pages/admin/create', 'id_parent' => $id_parent), 
										'visible' => Yii::app()->user->checkAccess('pages/admin/create')),

							array('label' => 'Выделить', 
										'icon' => 'check',
										'url' => '#',
										'linkOptions' => array('onclick' => 'jQuery("#page-select-form").submit(); return false;'),
										'visible' => !$modPage->hasSelection && Yii::app()->user->checkAccess('pages/admin')),

							array('label' => 'Переместить', 
										'icon' => 'file',
										'url' => array('/pages/admin/moveSelected', 'id_dst' => $id_parent), 
										'linkOptions' => array('confirm' => 'Точно?'),
										'visible' => $modPage->hasSelection && Yii::app()->user->checkAccess('pages/admin')),

							array('label' => 'Снять выделение', 
										'icon' => 'file',
										'url' => array('/pages/admin/unselectAll') , 
										'visible' => $modPage->hasSelection && Yii::app()->user->checkAccess('pages/admin')),



		);


		$this->render('admin', array('modPage' => $modPage));
	}

	//----------------------------------------------------------------------------
	public function actionView($id)
	//----------------------------------------------------------------------------
	{
		$modPage = $this->loadModel($id);
		
		$this->pageTitle = 'Просмотр';
		$this->menu = array(
										array('label' => 'Опции'), 
										array('label'=>'Редактировать', 
													'icon' => 'pencil',
													'url' => array('/pages/admin/update', 'id' => $modPage->id), 
													'visible' => Yii::app()->user->checkAccess('pages/admin/update')),
										
										array('label'=>'Удалить', 
													'icon' => 'trash',
													'url' => '#', 
													'linkOptions'=>array('submit'=>array('/pages/admin/delete', 'id' => $modPage->id), 'confirm'=>'Точно?'), 
													'visible' => Yii::app()->user->checkAccess('pages/admin/delete')),
		);
		
		$this->render('view', array('modPage' => $modPage));
	}

	public function getSettingsAccess()
	{
		return Yii::app()->user->checkAccess('root');
	}

	//----------------------------------------------------------------------------
	public function actionCreate($id_parent = 0)
	//----------------------------------------------------------------------------
	{
		$modPage = new Page;
		$modPage->id_parent = $id_parent;

		if(isset($_POST['Page']))
		{
			$modPage->attributes = $_POST['Page'];

			if($modPage->save() && $this->attachImages($modPage))
			{
				if ($_POST['refresh'] == 1)	$this->redirect(array('/pages/admin/update', 'id' => $modPage->id));
				else $this->redirect(array('/pages/admin/admin', 'id_parent' => $modPage->id_parent));
			}
		}
		else $this->initPageStatePrevious();

		foreach ($modPage->parents as $modParent)
			$this->breadcrumbs[$modParent->title] = array('/pages/admin/admin', 'id_parent' => $modParent->id);


		$this->menu = $this->getPageMenu($modPage);

		$this->pageTitle = 'Новая страница';
		if ($this->settingsAccess) $this->showTitle = false;

		$this->render('create', array('modPage' => $modPage));
	}

	//----------------------------------------------------------------------------
	public function actionUpdate($id)
	//----------------------------------------------------------------------------
	{
		$modPage = $this->loadModel($id);

		if(isset($_POST['Page']))
		{
			$modPage->attributes = $_POST['Page'];
			if($modPage->save() && $this->attachImages($modPage)) 
			{
				if ($_POST['refresh'] == 1)	$this->redirect(array('/pages/admin/update', 'id' => $modPage->id));
				else $this->redirect(array('/pages/admin/admin', 'id_parent' => $modPage->id_parent));
			}

		}
		else $this->initPageStatePrevious(array('admin')); // Переопределите если нужно

		$this->menu = $this->getPageMenu($modPage);

		foreach ($modPage->parents as $modParent)
			$this->breadcrumbs[$modParent->title] = array('/pages/admin/admin', 'id_parent' => $modParent->id);
		
		$this->pageTitle = $modPage->title;
		if ($this->settingsAccess) $this->showTitle = false;

		$this->render('update', array('modPage' => $modPage));
	}

	//----------------------------------------------------------------------------
	public function actionDelete($id)
	//----------------------------------------------------------------------------  
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Ошибка запроса.');
	}

	//****************************************************************************
	// Работа с выделением
	//****************************************************************************

	//----------------------------------------------------------------------------
	public function actionSelect()
	//----------------------------------------------------------------------------
	{
		$modPage = new Page;
		foreach ($_POST['id'] as $id) 
			$modPage->selectByPk($id);

		$this->redirectBack();
	}

	//----------------------------------------------------------------------------
	public function actionUnselectAll()
	//----------------------------------------------------------------------------
	{
		Page::model()->unselectAll();
		$this->redirectBack();
	}

	//----------------------------------------------------------------------------
	public function actionMoveSelected($id_dst)
	//----------------------------------------------------------------------------
	{
		$objPage = new Page;
		foreach ($objPage->selectedPk as $id) 
		{
			$modPage = $objPage->findByPk($id);
			$modPage->id_parent = $id_dst;
			$modPage->save();
		}

		Page::model()->unselectAll();
		$this->redirectBack();
	}

	//****************************************************************************
	// Вспомогательные функции
	//****************************************************************************

	//----------------------------------------------------------------------------
	public function loadModel($id)
	//----------------------------------------------------------------------------
	{
		$modPage = Page::model()->findByPk($id);
		if($modPage === null)
			throw new CHttpException(404,'Такой страницы нет!');
		return $modPage;
	}

	//----------------------------------------------------------------------------
	public function getPageMenu($modPage)
	//----------------------------------------------------------------------------
	{
		return 	array(                          
						array('label' => 'Открыть на сайте', 
								'icon' => 'share-alt',
								'url' => array('/site/pages/view', 'path' => $modPage->urlFull), 
								'linkOptions' => array('target' => '_blanc'),
								),

						array('label' => 'Применить', 
								'icon' => 'refresh',
								'url' => '#', 
								'linkOptions' => array('onclick' => 'jQuery("#refresh").val(1); jQuery("#page-form").submit(); return false;'),
								//'linkOptions' => array('onclick' => 'jQuery("#page-select-form").submit(); return false;'),

								),

						);

	}	

	//----------------------------------------------------------------------------
	public function attachImages($modPage)
	//----------------------------------------------------------------------------
	{
		if (!$modPage->isMarkdown) return true;
		else {
			// Удалить предыдущие связи
			PageFile::model()->deleteAllByAttributes(array('id_page' => $modPage->id));

			// Подключить рисунки
			if(isset($_POST['Page']['images'])) {
				foreach ($_POST['Page']['images'] as $sttImage) {

					// Сохранить имя файла
					$modFile = File::model()->findByPk($sttImage['id']);
					$modFile->name = $sttImage['name'];
					$modFile->save();

					// Сохранить связь файла с моделью
					$modPageFile = new PageFile;
					$modPageFile->id_page = $modPage->id;
					$modPageFile->id_file = $sttImage['id'];
					$modPageFile->save();				
				}
			}	


		}


		return true;	
	}	
}
