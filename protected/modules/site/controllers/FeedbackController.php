<?php
# ver: 1.0.p.0.1
# com: Добавлен функционал обратного звонка 

Yii::import('application.modules.feedback.models.Feedback');

class FeedbackController extends DsController
{
	public $feedback;
	public $showSlider = false;

	//----------------------------------------------------------------------------
	public function actions() {
	//----------------------------------------------------------------------------
        return array(
            'captcha'=>array(
                'class'=>'CCaptchaAction',
            ),
        );
    }

	//----------------------------------------------------------------------------
	public function actionForm()
	//----------------------------------------------------------------------------
	{
		$this->pageTitle = 'Обратная связь';

		$modFeedback = new Feedback('feedback');

 		if(isset($_POST['Feedback']))
        {
            $modFeedback->attributes = $_POST['Feedback'];
            if($modFeedback->save()) {

				$modSettings = new Settings;
				Yii::app()->mail->sendMail(Yii::app()->settings->feedbackEmail, 
											'Обратная связь от ' . $modFeedback->name, 
											'letter', 
											array('modFeedback' => $modFeedback));

                $this->redirect(array('sent'));

            }
        }
        
		$this->render('form', array('modFeedback' => $modFeedback));
	}


	//----------------------------------------------------------------------------
	public function actionCallback()
	//----------------------------------------------------------------------------
	{
		$this->pageTitle = 'Обратный звонок';

		$modFeedback = new Feedback('callback');
		$modFeedback->flg_phonecall = 1;

 		if(isset($_POST['Feedback'])) $modFeedback->attributes = $_POST['Feedback'];

        if($modFeedback->save()) {
			$modSettings = new Settings;
			Yii::app()->mail->sendMail(Yii::app()->settings->feedbackEmail, 
										'Заказ звонка от ' . $modFeedback->name, 
										'letter', 
										array('modFeedback' => $modFeedback));
        }
        
        $this->feedback = $modFeedback;

		$this->render('callback', array('modFeedback' => $modFeedback));
	}

	//----------------------------------------------------------------------------
	public function actionSent()
	//----------------------------------------------------------------------------
	{
		$this->breadcrumbs = array();
		$this->pageTitle = 'Сообщение отправлено!';
		$this->render('sent');
	}

}