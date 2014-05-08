<?php
return array(

	// application components
	'components'=>array(
		'db'=>array(
			'database' => 'h1265_ddb',
			'username' => 'h1265_duser',
			'password' => 'dsr2wSx'
			),


		'mail'=>array(
			'Mailer' => 'smtp',
			'Host' => 'localhost',
			'Username' => 'studio@deka-web.ru',
			'Password' => 'dbr3eDc',
		),	


	),
	'modules'=>array(
		'backuper' => array('serverName' => 'SRV'), 



  ),
);