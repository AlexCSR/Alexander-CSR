<?php

# ver: 1.0.0
# req: /protected/modules/feedback/models/Feedback.php 1.0
# req: /protected/modules/feedback/views/admin/list.php


class AdminController extends DcController
{
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
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

  //----------------------------------------------------------------------------
  public function getRequest()
  //----------------------------------------------------------------------------  
  {
    return isset($_GET['request']) ? $_GET['request'] : '';
  }

  //----------------------------------------------------------------------------
  public function actionAdmin()
  //----------------------------------------------------------------------------
	{
    $modFeedback = new Feedback;

    $modFeedback->setDbCriteriaAdmin($this->request);
    //$modFeedback->setSort(array('defaultOrder' => array('id' => true)));    
    //$modFeedback->setPagination(false); 

    $this->pageTitle = 'Обратная связь';
    $this->menu = array(
                    array('label'=>'Все прочитано', 
                          'icon' => 'ok',
                          'url' => array('/feedback/admin/readAll'), 
                          'visible' => Yii::app()->user->checkAccess('feedback/admin/readAll'),
                          'linkOptions' => array('confirm' => 'Точно?')),
    );

		$this->render('list', array('modFeedback' => $modFeedback));
	}

  //----------------------------------------------------------------------------
  public function actionReadAll()
  //----------------------------------------------------------------------------  
  {
    Feedback::model()->updateAll(array('flg_new' => 0));
    $this->redirectBack();
  }

    //----------------------------------------------------------------------------
  public function loadModel($id)
  //----------------------------------------------------------------------------
	{
		$modFeedback = Feedback::model()->findByPk($id);
		if($modFeedback === null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $modFeedback;
	}

  //----------------------------------------------------------------------------
	protected function performAjaxValidation($modFeedback)
  //----------------------------------------------------------------------------	
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='feedback-form')
		{
			echo CActiveForm::validate($modFeedback);
			Yii::app()->end();
		}
	}
}
