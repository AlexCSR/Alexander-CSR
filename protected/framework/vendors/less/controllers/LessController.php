<?php


class LessController extends CController
{
	public $defaultAction = 'compile';

	public function actionCompile()
	{
		$arrFiles = Yii::app()->getModule('less')->files;

		$cntError = 0;
		$cntOk = 0;

		foreach ($arrFiles as $sttFile) {
			if (!isset($sttFile['formatter'])) 
				$sttFile['formatter'] = 'classic';

			if (!isset($sttFile['less']) || !is_file($sttFile['less']) || !isset($sttFile['css'])) {
				$cntError++;
				continue;
			} else {

				$objLess = new lessc;
				$objLess->setFormatter($sttFile['formatter']);
				
				if($objLess->compileFile($sttFile['less'], $sttFile['css'])) $cntOk++;
				else $cntError++;
			}
		}

		// Сообщить о результатах
		Yii::app()->user->setFlash($cntError > 0 ? 'error' : 'info', "Компиляция завершена. Успешно: $cntOk. Ошибок: $cntError. <strong>Не забудь про публикацию ресурсов!</strong>");

		$this->redirect(Yii::app()->request->urlReferrer);
		
	}
}

 