<?php

# ver: 1.1.0
# req: /protected/modules/files/views/admin/admin.php
# req: /protected/modules/files/views/admin/create.php
# req: /protected/modules/files/views/admin/update.php

class AdminController extends DcController
{
	public $defaultAction = 'admin';
	public $defaultActionName = 'Файлы';

	//----------------------------------------------------------------------------
	public function fileBreadcrumbs($modFile)
	//----------------------------------------------------------------------------
	{
		$arrRet = array();
		foreach ($modFile->parents as $modParent) 
			$arrRet[$modParent->name] = array('/files/admin/admin', 'id_parent' => $modFile->id_parent);
		return $arrRet;
	}

	//----------------------------------------------------------------------------
	public function actionAdmin($id_parent = 0)
	//----------------------------------------------------------------------------
	{
		$modFile = new File('search');
		$modFile->unsetAttributes();
		
		if(isset($_GET['File'])) $modFile->attributes = $_GET['File'];
		$modFile->id_parent = $id_parent;

		if ($id_parent != 0) {
			$modParent = File::model()->findByPk($id_parent);
			$this->breadcrumbs = array_merge(
					array('Файлы' => array('/files/admin/admin')),
					$this->fileBreadcrumbs($modParent)
				);
			$this->pageTitle = $modParent->name;
		}


		$this->menu = array(                          
							array('label' => 'Опции'), 

							array('label' => 'Добавить папку', 
										'icon' => 'plus',
										'url' => array('/files/admin/createFolder', 'id_parent' => $id_parent), 
										'visible' => Yii::app()->user->checkAccess('files/admin/create')),

							array('label' => 'Выделить', 
										'icon' => 'check',
										'url' => '#',
										'linkOptions' => array('onclick' => 'jQuery("#files-select-form").submit(); return false;'),
										'visible' => !$modFile->hasSelection && Yii::app()->user->checkAccess('files/admin')),

							array('label' => 'Снять выделение', 
										'icon' => 'file',
										'url' => array('/files/admin/unselectAll') , 
										'visible' => $modFile->hasSelection && Yii::app()->user->checkAccess('files/admin')),

							array('label' => 'Переместить', 
										'icon' => 'file',
										'url' => array('/files/admin/moveSelected', 'id_dst' => $id_parent), 
										'linkOptions' => array('confirm' => 'Точно?'),
										'visible' => $modFile->hasSelection && Yii::app()->user->checkAccess('files/admin')),


		);


		$this->render('admin', array('modFile' => $modFile));
	}

	//----------------------------------------------------------------------------
	public function actionCreateFolder($id_parent = 0)
	//----------------------------------------------------------------------------
	// Создавать можно только папки
	{
		$modFile = new File('folderInsert');
		$modFile->flg_folder = 1;
		$modFile->id_parent = $id_parent;

		if ($id_parent != 0) {
			$modParent = $modFile->findByPk($id_parent);
			$this->breadcrumbs = array_merge(
					$this->breadcrumbs,
					$this->fileBreadcrumbs($modParent),
					array($modParent->name => array('/files/admin/admin', array('id_parent' => $modParent->id)))
				);
		}

		if(isset($_POST['File']))
		{
			$modFile->attributes = $_POST['File'];
			if($modFile->save())
				$this->redirectPageStatePrevious();
		}
		else $this->initPageStatePrevious();

		$this->pageTitle = 'Добавить';

		$this->render('create', array('modFile' => $modFile));
	}

	//----------------------------------------------------------------------------
	public function actionUploadFiles($id_parent = 0)
	//----------------------------------------------------------------------------
	{
		$arrFiles = CUploadedFile::getInstancesByName('source');

		foreach ($arrFiles as $objFile) {
			$modFile = File::createByFile($objFile);
			$modFile->id_parent = $id_parent;

			if (!$modFile->save())
			{
				$strErrors = '';
				foreach ($modFile->errors as $arrErrors) 
					foreach ($arrErrors as $value) 
						$strErrors .= $value . "\n";
				Yii::app()->user->setFlash('error', $strErrors);
			}
		}

		$this->redirectBack();
	}

	//----------------------------------------------------------------------------
	public function actionUpdate($id)
	//----------------------------------------------------------------------------
	{
		$modFile = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['File']))
		{
			$modFile->attributes = $_POST['File'];
			if($modFile->save())
				$this->redirectPageStatePrevious();
		}
		else $this->initPageStatePrevious(array('view', 'id' => $modFile->id)); // Переопределите если нужно


		$this->pageTitle = 'Редактировать';

		$this->render('update', array('modFile' => $modFile));
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

	//----------------------------------------------------------------------------
	public function loadModel($id)
	//----------------------------------------------------------------------------
	{
		$modFile = File::model()->findByPk($id);
		if($modFile === null)
			throw new CHttpException(404,'Такой страницы нет!');
		return $modFile;
	}

	//****************************************************************************
	// Работа с выделением
	//****************************************************************************

	//----------------------------------------------------------------------------
	public function actionSelect()
	//----------------------------------------------------------------------------
	{
		$modFile = new File;
		foreach ($_POST['id'] as $id) 
			$modFile->selectByPk($id);

		$this->redirectBack();
	}

	//----------------------------------------------------------------------------
	public function actionUnselectAll()
	//----------------------------------------------------------------------------
	{
		File::model()->unselectAll();
		$this->redirectBack();
	}

	//----------------------------------------------------------------------------
	public function actionMoveSelected($id_dst)
	//----------------------------------------------------------------------------
	{
		$objFile = new File;
		$arrErrors = array();
		foreach ($objFile->selectedPk as $id) 
		{
			$modFile = $objFile->findByPk($id);
			$modFile->id_parent = $id_dst;
			if (!$modFile->save()) 
				$arrErrors[] = $modFile;
		}

		File::model()->unselectAll();
		if (count($arrErrors) > 0)
			Yii::app()->user->setFlash('error', CHtml::errorSummary($arrErrors, '<p>Проблемы с перемещением... Вот такие:</p>'));
		$this->redirectBack();
	}

	//----------------------------------------------------------------------------
	public function actionDownload($id)
	//----------------------------------------------------------------------------
	{
		$modFile = $this->loadModel($id);

		// $modFile->saveCounters(array('cnt_download' => 1));

		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");;
		header("Content-Disposition: attachment; filename=" . $modFile->name);
		header("Content-Transfer-Encoding: binary ");  

		echo file_get_contents($modFile->sourcePath);


		$this->disableLogs();
		Yii::app()->end();
	}
}
