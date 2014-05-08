<?php
return array(

	'modules'=>array(
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123',
      		'generatorPaths'=>array('ext.gii'),			
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1')),
	),

	// application components
	'components'=>array(
		'bootstrap'=>array(
			'debug' => false,
		),	

		'mail'=>array(

			'Mailer' => 'smtp',
			'SMTPAuth' => true,
			'Host' => '',
			'Username' => '',
			'Password' => '',
		),

		'less'=>array(
			'enabled' => false,
			'class'=>'system.vendors.less.components.LessCompiler',
			'forceCompile' => true,
			'paths' => array('protected/extensions/bootstrap/lib/bootstrap/less/bootstrap.less' => 'protected/extensions/bootstrap/assets/css/bootstrap.less.css')),

		'db'=>array(
			'database' => 'dw_peppol_1_dlp',
			'username' => 'root',
			'password' => '123',
			'enableProfiling' => true,
			'enableParamLogging' => true),
		
		'log' => array(
			'routes'=>array(
				array(
					'class'=>'ext.db_profiler.DbProfileLogRoute',
					'countLimit' => 1, 
					'slowQueryMin' => 0.01,
					'enabled' => true,
				),								
			)),

	),
);