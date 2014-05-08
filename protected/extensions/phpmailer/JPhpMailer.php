<?php

# ver: 1.1.0.2
# req: /protected/views/layouts/email.php

/*
	// main.php
	'components'=>array(
		'mail'=>array(
			'class' => 'application.extensions.phpmailer.JPhpMailer',
			'Layout' => 'application.views.layouts.email',
			'fromAddress' => 'noreply@klaya.ru',
			'fromName' => 'Кладовая',
		),
	),

	// main_local.php
	'mail'=>array(
		'Mailer' => 'debug',
	),

	// mail_server.php
	'mail'=>array(
		'Mailer' => 'smtp',
		'Host' => 'mail.klaya.ru',
		'Username' => 'noreply@klaya.ru',
		'Password' => 'kar3eDc',
	),	

	// Использование в коде:
	Yii::app()->mail->sendMail($modRegister->email, 'Регистрация прошла успешно', 'registerLetter', array('modUser' => $modRegister));

	// Не забыть в лейауте
	<!-- Отладчик EMAIL -->
	<?php $this->widget('application.extensions.phpmailer.Debug'); ?>

	

*/


/**
 * JPhpMailer class file.
 *
 * @version alpha 2 (2010-6-3 16:42)
 * @author jerry2801 <jerry2801@gmail.com>
 * @required PHPMailer v5.1
 *
 * A typical usage of JPhpMailer is as follows:
 * <pre>
 * Yii::import('ext.phpmailer.JPhpMailer');
 * $mail=new JPhpMailer;
 * $mail->IsSMTP();
 * $mail->Host='smpt.163.com';
 * $mail->SMTPAuth=true;
 * $mail->Username='yourname@yourdomain';
 * $mail->Password='yourpassword';
 * $mail->SetFrom('name@yourdomain.com','First Last');
 * $mail->Subject='PHPMailer Test Subject via smtp, basic with authentication';
 * $mail->AltBody='To view the message, please use an HTML compatible email viewer!';
 * $mail->MsgHTML('<h1>JUST A TEST!</h1>');
 * $mail->AddAddress('whoto@otherdomain.com','John Doe');
 * $mail->Send();
 * </pre>
 */

require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'class.phpmailer.php';

class JPhpMailer extends PHPMailer
{
	public $fromAddress;
	public $fromName;
	public $CharSet = 'utf-8';
	public $Layout;

	//----------------------------------------------------------------------------
	public function init()
	//----------------------------------------------------------------------------
	{
		$this->SetFrom($this->fromAddress, $this->fromName);
	}

	//----------------------------------------------------------------------------
	public function renderMessage($template, $params = array())
	//----------------------------------------------------------------------------
	{
		$this->MsgHTML(Yii::app()->controller->renderPartial($template, $params, true));
	}

	//----------------------------------------------------------------------------
	public function sendMail($mixAddress, $strSubject, $strTemplate, $arrParams = array())
	//----------------------------------------------------------------------------
	{
		$this->ClearAddresses();

		// Сформировать текст письма
		$strView = Yii::app()->controller->renderPartial($strTemplate, $arrParams, true);
		if ($this->Layout === null) $strContent = $strView;
		else $strContent = Yii::app()->controller->renderPartial($this->Layout, array('content' => $strView, 'letter' => $arrParams), true);


		if ($this->Mailer == 'debug') {
			$strDebug = Yii::app()->controller->renderPartial('ext.phpmailer.views.debug',
						array('to' => is_array($mixAddress) ? implode(', ', $mixAddress) : $mixAddress, 'subject' => $strSubject, 'message' => $strContent),
						true);

			Yii::app()->user->setFlash('email', $strDebug);
			return true;
			
		} else {


			// Если адрес один, присвоить сразу. Иначе - в цикле.
			if (!is_array($mixAddress)) $this->AddAddress($mixAddress);
			else
				foreach ($mixAddress as $strAddress)
					$this->AddAddress($strAddress);

			$this->Subject = $strSubject;

			$this->MsgHTML($strContent);
			return $this->Send();
		}
	}
}