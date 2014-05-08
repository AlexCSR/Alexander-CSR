<?php

# ver: 1.0.0
# req: /protected/modules/backuper/models/BackuperBackup.php 1.0
# req: /protected/modules/backuper/views/backup/admin.php
# req: /protected/modules/backuper/views/backup/form.php
# req: /protected/modules/backuper/views/backup/view.php

class BackupController extends DcController
{
	// Действие по умолчанию
	public $defaultAction = 'admin';                
	public $defaultActionName = 'Резервные копии';  

	//----------------------------------------------------------------------------
	public function loadModel($urlBackup)
	//----------------------------------------------------------------------------
	{
		$objBackup = new BackuperBackup; 
		$modBackup = $objBackup->findByPk($urlBackup);
		if ($modBackup === null)
			throw new CHttpException(404, 'Бекап не найден');
			
		return $modBackup;
	}
	
	//----------------------------------------------------------------------------
	public function actionCreate()
	//----------------------------------------------------------------------------  
	{
		$this->pageTitle = 'Новый бекап';
		
		$modBackup = new BackuperBackup;
		$modBackup->server_name = $this->module->serverName;

		// Выполнить сохранение
		if(isset($_POST['BackuperBackup']))
		{
			$modBackup->attributes = $_POST['BackuperBackup'];
			if($modBackup->save())
				$this->redirectPageStatePrevious();
		}
		else $this->initPageStatePrevious();

		// Передать контроллеру    
		$this->render('form', array('modBackup' => $modBackup));
	}

	//----------------------------------------------------------------------------
	public function actionAdmin()
	//----------------------------------------------------------------------------
	{
		$this->pageTitle = 'Резервные копии';
		
		$modBackup = new BackuperBackup;

		$this->menu = array(                          
							array('label' => 'Опции'), 
							array('label' => 'Сделать бекап', 
										'icon' => 'plus',
										'url' => array('/backuper/backup/create'), 
										'visible' => Yii::app()->user->checkAccess('backuper/backup/create')),
		);
		
				
		$this->render('admin', array('modBackup' => $modBackup));
	}

	//----------------------------------------------------------------------------
	public function actionView($urlBackup)
	//----------------------------------------------------------------------------  
	{
		$modBackup = $this->loadModel($urlBackup);
		
		$this->pageTitle = $modBackup->name;

		$this->menu = array(   
							array('label' => 'Опции'), 
							array(
								'label'=>'Восстановить бекап', 
								'icon' => 'refresh', 
								'url' => '#',
								'linkOptions'=>array('submit'=>array('retreive', 'urlBackup' => $urlBackup), 'confirm'=>'Точно?'),
								'visible' => (Yii::app()->user->checkAccess('backuper/backup')),
								),
		);                       

		$this->render('view', array('model' => $modBackup, 'attributes' => null));
	}

	//----------------------------------------------------------------------------
	public function actionRetreive($urlBackup)
	//----------------------------------------------------------------------------  
	{
		$objBackup = new BackuperBackup;

		if (!$objBackup->retreiveByPk($urlBackup)) 
			Yii::app()->user->setFlash('error', '<strong>Бекап ' . $urlBackup . ' не восстановлен: </strong><br>' . $objBackup->error);
		else Yii::app()->user->setFlash('info', 'Бекап ' . $urlBackup . ' восстановлен');
		

		
		
		$this->redirect(array('admin'));
	}
	
	//----------------------------------------------------------------------------  
	public function actionDelete($urlBackup)
	//----------------------------------------------------------------------------  
	{
		if(Yii::app()->request->isPostRequest)
		{
			$objBackup = new BackuperBackup;
			$modBackup = $objBackup->deleteByPk($urlBackup);

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
			{
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			}
		}
		else throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

}