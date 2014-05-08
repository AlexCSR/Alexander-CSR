<?php

# ver: 1.0.p.1
# com: Загрузка картинки для Imperavi 

class FilesWidgetController extends DcController
{

	//****************************************************************************
	// Выбор из каталога
	//****************************************************************************

	//----------------------------------------------------------------------------
	public function actionCatalog($id_folder = 0)
	//----------------------------------------------------------------------------
	// Вывести файлы списком
	{
		$modFile = new File('search');
		$modFile->unsetAttributes();
		
		if(isset($_GET['File'])) $modFile->attributes = $_GET['File'];
		$modFile->id_parent = $id_folder;  

		$breadcrumbs = array();
		if ($id_folder != 0) {
			$modParent = File::model()->findByPk($id_folder);
			$breadcrumbs = array_merge(
					array('Файлы' => Yii::app()->createUrl('/files/filesWidget/catalog')),
					$this->fileBreadcrumbs($modParent),
					array($modParent->name)
				);
		} else $breadcrumbs = array('Файлы');

		$this->renderPartial('application.modules.files.widgets.views.catalog', array('modFile' => $modFile, 'id_folder' => $id_folder, 'breadcrumbs' => $breadcrumbs));		
		die();
	}

	//----------------------------------------------------------------------------
	public function fileBreadcrumbs($modFile)
	//----------------------------------------------------------------------------
	{
		$arrRet = array();
		foreach ($modFile->parents as $modParent) 
			$arrRet[$modParent->name] = Yii::app()->createUrl('/files/filesWidget/catalog', array('id_folder' => $modFile->id));
		return $arrRet;
	}


	//----------------------------------------------------------------------------
	public function actionCatalogAdd()
	//----------------------------------------------------------------------------
	{		
		// Отрисовать инпуты для добавленных файлов
		if (isset($_POST['FilesCatalog'])) {
			foreach ($_POST['FilesCatalog']['id_file'] as $id_file) {
				$this->renderPartial('application.modules.files.widgets.views.filesItem', 
									array(
										'name' => $_POST['FilesCatalog']['attributeName'],
										'modFile' => File::model()->findByPk($id_file),
										'itemView' => $this->getPageState('files-widget-item-view')
										));

			}
			
		}

		$this->disableLogs();
		Yii::app()->end();
	}

	//----------------------------------------------------------------------------
	public function actionView($id, $name, $itemView)
	//----------------------------------------------------------------------------
	{
		$this->renderPartial('application.modules.files.widgets.views.filesItem', 
								array(
								'name' => $name,
								'modFile' => File::model()->findByPk($id),
								'itemView' => $itemView
								)
							);

		$this->disableLogs();
		Yii::app()->end();

	}

	//----------------------------------------------------------------------------
	public function actionUpload()
	//----------------------------------------------------------------------------
	// Загрузить файл, сообщить номер
	{
		$arrRet = array('error' => '', 'id' => 0);

		if ($objFile = CUploadedFile::getInstanceByName('FilesCatalog[file]'))
		{
			$modImage = File::createByFile($objFile);

			if ($modImage->save()) $arrRet['id'] = $modImage->id;
			else
			{
				$arrRet['error'] = 'Не получилось загрузить... ';
				foreach ($modImage->errors as $arrFieldErrors) 					
					$arrRet['error'] .= implode(', ', $arrFieldErrors);
			}
		}

		echo CJSON::encode($arrRet);

		Yii::app()->controller->disableLogs();
		Yii::app()->end();
	}

	//----------------------------------------------------------------------------
	public function actionUploadImperavi($id_page)
	//----------------------------------------------------------------------------
	// Работает только для картинок
	{
		$arrRet = array();

		if ($objFile = CUploadedFile::getInstanceByName('file'))
		{
			$modImage = File::createByFile($objFile);

			if ($modImage->save()) {

				// Сохранить связь файла с моделью
				$modPageFile = new PageFile;
				$modPageFile->id_page = $id_page;
				$modPageFile->id_file = $modImage->id;
				$modPageFile->save();				

				$arrRet['filelink'] = $modImage->publish('page.jpg');
				echo stripslashes(json_encode($arrRet));
			} 
		}


	}	

	//----------------------------------------------------------------------------
	public function actionUploadFileImperavi($id_page)
	//----------------------------------------------------------------------------
	// Работает только для картинок
	{
		$arrRet = array();

		if ($objFile = CUploadedFile::getInstanceByName('file'))
		{
			$modFile = File::createByFile($objFile);

			if ($modFile->save()) {
				$arrRet['filelink'] = $modFile->downloadUrl;
				$arrRet['filename'] = $modFile->name;


				echo stripslashes(json_encode($arrRet));
			} 
		}
	}	


}
