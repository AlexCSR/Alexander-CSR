<?php

# ver: 1.0.0.1

class BugController extends DcController
{
	public $defaultAction = 'admin';
	public $defaultActionName = 'Техподдержка';

	//----------------------------------------------------------------------------
	public function actionAdmin()
	//----------------------------------------------------------------------------
	{
		$modBug = new Bug('search');
		$modBug->unsetAttributes();
		
		if(isset($_GET['Bug'])) $modBug->attributes = $_GET['Bug'];

		$this->pageTitle = 'Техподдержка';
		$this->menu = array(                          
										array('label' => 'Опции'), 
										array('label' => 'Добавить', 
													'icon' => 'plus',
													'url' => array('/bugs/bug/create'), 
													'visible' => Yii::app()->user->checkAccess('bugs/bug/create')),
		);


		$this->render('admin', array('modBug' => $modBug));
	}

   	//---------------------------------------------------------------------------- 
    public function actionView($id) 
    //---------------------------------------------------------------------------- 
    { 
        $modBug = $this->loadModel($id); 
         
        $this->pageTitle =  $modBug->enum['id_type'] . ' № ' . $modBug->id . ': ' . $modBug->name; 
 

        $arrStates = array();
        foreach ($modBug->enum_id_state as $key => $value) {
        	$arrStates[] = array(
        			'label' => $value,  
					'url' => array('/bugs/bug/setState', 'id' => $modBug->id, 'id_state' => $key),  
					'visible' => Yii::app()->user->checkAccess('bugs/bug/update'),
					'active' => $modBug->id_state == $key,
					);       		
        }

        $this->menu = array_merge(array( 
                                        array('label' => 'Опции'),  
                                        array('label'=>'Редактировать',  
                                                    'icon' => 'pencil', 
                                                    'url' => array('/bugs/bug/update', 'id' => $modBug->id),  
                                                    'visible' => Yii::app()->user->checkAccess('bugs/bug/update')), 
                                         
                                        array('label'=>'Удалить',  
                                                    'icon' => 'trash', 
                                                    'url' => '#',  
                                                    'linkOptions'=>array('submit'=>array('/bugs/bug/delete', 'id' => $modBug->id), 'confirm'=>'Точно?'),  
                                                    'visible' => Yii::app()->user->checkAccess('bugs/bug/delete')), 
                                        array('label'=>'Статус')
                                        ),
									$arrStates
        ); 
         
        $this->render('view', array('modBug' => $modBug)); 
    } 

	//----------------------------------------------------------------------------
    public function actionSetState($id, $id_state)
	//----------------------------------------------------------------------------
    {
    	$modBug = $this->loadModel($id);
    	$modBug->id_state = $id_state;

    	if ($id_state == Bug::STATE_FIXED) $modBug->time_done = time();
    	else $modBug->time_done = 0;

    	$modBug->save();

    	$modMessage = new Message;
    	$modMessage->id_bug = $modBug->id;
    	$modMessage->text = 'Статус изменен на "' . $modBug->enum['id_state'] . '"';
    	$modMessage->save();

    	$this->redirectBack();
    }

	//----------------------------------------------------------------------------
	public function actionCreate($url = '')
	//----------------------------------------------------------------------------
	{
		$modBug = new Bug;
		if ($url != '') $modBug->url = $url;

		if(isset($_POST['Bug']))
		{
			$modBug->attributes = $_POST['Bug'];
			if($modBug->save()) {

				// Отправить письмо разработчику
				$email = Yii::app()->getModule('bugs')->newBugMail;

				if ($email != null && $modBug->id_state == Bug::STATE_NEW)
					Yii::app()->mail->sendMail($email, 
											$modBug->enum['id_type'] . ' № ' . $modBug->id . ': ' . $modBug->name, 
											'mail', 
											array('modBug' => $modBug, 'username' => 'Разработчик'));


				$this->redirect(array('/bugs/bug/view', 'id' => $modBug->id));
			}
		}
		else $this->initPageStatePrevious();

		$this->pageTitle = 'Добавить';

		$this->render('create', array('modBug' => $modBug));
	}

	//----------------------------------------------------------------------------
	public function actionUpdate($id)
	//----------------------------------------------------------------------------
	{
		$modBug = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Bug']))
		{
			$modBug->attributes = $_POST['Bug'];
			if($modBug->save())
				$this->redirectPageStatePrevious();
		}
		else $this->initPageStatePrevious(array('view', 'id' => $modBug->id)); // Переопределите если нужно


		$this->pageTitle = 'Редактировать';

		$this->render('update', array('modBug' => $modBug));
	}

	//----------------------------------------------------------------------------
	public function actionDelete($id)
	//----------------------------------------------------------------------------  
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			$this->redirect(array('admin'));
		}
		else
			throw new CHttpException(400,'Ошибка запроса.');
	}

	//----------------------------------------------------------------------------
	public function loadModel($id)
	//----------------------------------------------------------------------------
	{
		$modBug = Bug::model()->findByPk($id);
		if($modBug === null)
			throw new CHttpException(404,'Такой страницы нет!');
		return $modBug;
	}
}
