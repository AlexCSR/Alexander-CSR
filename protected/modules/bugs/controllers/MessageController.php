<?php

# ver: 1.0.0

class MessageController extends DcController
{
	public $defaultAction = 'admin';
	public $defaultActionName = 'Администрирование';

	//----------------------------------------------------------------------------
	public function actionCreate()
	//----------------------------------------------------------------------------
	{
		$modMessage = new Message;

		if(isset($_POST['Message']))
		{
			$modMessage->attributes = $_POST['Message'];
			$modMessage->save();
		}

		$this->redirectBack();
	}

	//----------------------------------------------------------------------------
	public function actionDelete($id)
	//----------------------------------------------------------------------------  
	{
		$this->loadModel($id)->delete();
		$this->redirectBack();
	}

    //---------------------------------------------------------------------------- 
    public function loadModel($id) 
    //---------------------------------------------------------------------------- 
    { 
        $modMessage = Message::model()->findByPk($id); 
        if($modMessage === null) 
            throw new CHttpException(404,'Такой страницы нет!'); 
        return $modMessage; 
    } 
}
