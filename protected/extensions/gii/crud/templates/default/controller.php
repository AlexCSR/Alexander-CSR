<?php
# ver: 1.0.0

/**
 * This is the template for generating a controller class file for CRUD feature.
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>

class <?php echo $this->controllerClass; ?> extends <?php echo $this->baseControllerClass."\n"; ?>
{
	public $defaultAction = 'admin';
	public $defaultActionName = 'Администрирование';

	//----------------------------------------------------------------------------
	public function actionList()
	//----------------------------------------------------------------------------
	{
		$mod<?php echo $this->modelClass; ?> = new <?php echo $this->modelClass; ?>('search');
		$mod<?php echo $this->modelClass; ?>->unsetAttributes();
		
		if(isset($_GET['<?php echo $this->modelClass; ?>'])) $mod<?php echo $this->modelClass; ?>->attributes = $_GET['<?php echo $this->modelClass; ?>'];

		$this->pageTitle = 'Список';
		$this->menu = array(
										array('label' => 'Опции'), 

										array('label' => 'Добавить', 
													'icon' => 'plus',
													'url' => array('/<?php echo $this->uniqueControllerId; ?>/create'), 
													'visible' => Yii::app()->user->checkAccess('<?php echo $this->uniqueControllerId; ?>/create')),
		);

		$this->render('list', array('mod<?php echo $this->modelClass; ?>' => $mod<?php echo $this->modelClass; ?>));
	}

	//----------------------------------------------------------------------------
	public function actionAdmin()
	//----------------------------------------------------------------------------
	{
		$mod<?php echo $this->modelClass; ?> = new <?php echo $this->modelClass; ?>('search');
		$mod<?php echo $this->modelClass; ?>->unsetAttributes();
		
		if(isset($_GET['<?php echo $this->modelClass; ?>'])) $mod<?php echo $this->modelClass; ?>->attributes = $_GET['<?php echo $this->modelClass; ?>'];

		$this->pageTitle = 'Администрирование';
		$this->menu = array(                          
										array('label' => 'Опции'), 
										array('label' => 'Добавить', 
													'icon' => 'plus',
													'url' => array('/<?php echo $this->uniqueControllerId; ?>/create'), 
													'visible' => Yii::app()->user->checkAccess('<?php echo $this->uniqueControllerId; ?>/create')),
		);


		$this->render('admin', array('mod<?php echo $this->modelClass; ?>' => $mod<?php echo $this->modelClass; ?>));
	}

	//----------------------------------------------------------------------------
	public function actionView($id)
	//----------------------------------------------------------------------------
	{
		$mod<?php echo $this->modelClass ?> = $this->loadModel($id);
		
		$this->pageTitle = 'Просмотр';
		$this->menu = array(
										array('label' => 'Опции'), 
										array('label'=>'Редактировать', 
													'icon' => 'pencil',
													'url' => array('/<?php echo $this->uniqueControllerId; ?>/update', 'id' => $mod<?php echo $this->modelClass ?>-><?php echo $this->tableSchema->primaryKey; ?>), 
													'visible' => Yii::app()->user->checkAccess('<?php echo $this->uniqueControllerId; ?>/update')),
										
										array('label'=>'Удалить', 
													'icon' => 'trash',
													'url' => '#', 
													'linkOptions'=>array('submit'=>array('/<?php echo $this->uniqueControllerId; ?>/delete', 'id' => $mod<?php echo $this->modelClass ?>-><?php echo $this->tableSchema->primaryKey; ?>), 'confirm'=>'Точно?'), 
													'visible' => Yii::app()->user->checkAccess('<?php echo $this->uniqueControllerId; ?>/delete')),
		);
		
		$this->render('view', array('mod<?php echo $this->modelClass ?>' => $mod<?php echo $this->modelClass ?>));
	}

	//----------------------------------------------------------------------------
	public function actionCreate()
	//----------------------------------------------------------------------------
	{
		$mod<?php echo $this->modelClass ?> = new <?php echo $this->modelClass; ?>;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['<?php echo $this->modelClass; ?>']))
		{
			$mod<?php echo $this->modelClass ?>->attributes = $_POST['<?php echo $this->modelClass; ?>'];
			if($mod<?php echo $this->modelClass ?>->save())
				$this->redirectPageStatePrevious();
		}
		else $this->initPageStatePrevious();

		$this->pageTitle = 'Добавить';

		$this->render('create', array('mod<?php echo $this->modelClass ?>' => $mod<?php echo $this->modelClass ?>));
	}

	//----------------------------------------------------------------------------
	public function actionUpdate($id)
	//----------------------------------------------------------------------------
	{
		$mod<?php echo $this->modelClass ?> = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['<?php echo $this->modelClass; ?>']))
		{
			$mod<?php echo $this->modelClass ?>->attributes = $_POST['<?php echo $this->modelClass; ?>'];
			if($mod<?php echo $this->modelClass ?>->save())
				$this->redirectPageStatePrevious();
		}
		else $this->initPageStatePrevious(array('view', 'id' => $mod<?php echo $this->modelClass ?>-><?php echo $this->tableSchema->primaryKey; ?>)); // Переопределите если нужно


		$this->pageTitle = 'Редактировать';

		$this->render('update', array('mod<?php echo $this->modelClass ?>' => $mod<?php echo $this->modelClass ?>));
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
		$mod<?php echo $this->modelClass; ?> = <?php echo $this->modelClass; ?>::model()->findByPk($id);
		if($mod<?php echo $this->modelClass; ?> === null)
			throw new CHttpException(404,'Такой страницы нет!');
		return $mod<?php echo $this->modelClass; ?>;
	}
}
