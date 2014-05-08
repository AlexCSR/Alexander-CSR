<?php

# ver: 1.1.0
# req: /protected/modules/settings/views/settings/view.php

class SettingsController extends DcController
{
	public $defaultAction = 'view';
	public $defaultActionName = 'Настройки';

	//----------------------------------------------------------------------------	 
	public function actionView()
	//----------------------------------------------------------------------------	 	
	{
		$modSettings = new Settings;


		if (isset($_POST['Settings']))
		{
			$modSettings->attributes = $_POST['Settings'];

			if ($modSettings->save()) {
				Yii::app()->user->setFlash('info', 'Настройки сохранены');
				$this->redirectBack();				
			}
			
		}

		$this->render('view', array('modSettings' => $modSettings));
	}
}