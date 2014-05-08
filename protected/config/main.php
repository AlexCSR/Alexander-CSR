<?php

# ver: 1.d.0.1

# req: /protected/components/ComponentsModule.php
# req: /protected/config/main.php
# req: /protected/extensions/gii/Gii.php
# req: /protected/modules/files/FilesModule.php
# req: /protected/modules/pages/PagesModule.php
# req: /protected/modules/settings/SettingsModule.php
# req: /protected/modules/users/UsersModule.php
# req: /protected/modules/site/SiteModule.php
# req: /protected/modules/feedback/FeedbackModule.php
# req: /protected/modules/backuper/BackuperModule.php
# req: /index.php

define ('SITE_DIR', dirname(__FILE__) . '/../../');

Yii::setPathOfAlias('bootstrap', 'protected/extensions/bootstrap');


return CMap::mergeArray(array(
	'basePath' => SITE_DIR . 'protected/',
	'name' => 'НУЦ - Peppol',
	'language' => 'ru',
	'defaultController' => 'pages',

	// preloading 'log' component
	'preload'=>array('log', 'settings'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
			
		'application.modules.users.components.*',
		'application.modules.users.models.*',

		'application.modules.files.components.*',
		'application.modules.files.models.*',

		'application.modules.pages.components.*',
		'application.modules.pages.models.*',

		'application.modules.settings.components.*',
		'application.modules.settings.models.*',
		'application.modules.banners.models.*',
		'application.modules.feedback.models.*',

	),

	'modules'=>array(
		'backuper' => array('serverName' => 'LCH'), 
		'site',
		'files' => array(
				'debug' => false,
				'thumbs' => array(
					'mic' => array('width' => 50, 'height' => 50),
					'list' => array('width' => 160, 'height' => 160, 'mode' => 1),	
					'banner' => array('width' => 229, 'mode' => 2),	
					'page.jpg' => array('width' => 600, 'mode' => 2),		
					'real' => array('width' => 1, 'mode' => 3),		
				),	

			),
		'pages',
		'users',
		'settings',
		'feedback',
		'banners',
		'bugs' => array('newBugMail' => 'tishurin@yandex.ru')
	),

	// application components
	'components'=>array(
		'user'=>array(
			'allowAutoLogin'=>true,
			'class' => 'DWebUser',
			'loginUrl' => array('users/login/login')),

		'bootstrap'=>array(
			// Если нужно делать кастомизацию, то: debug = true, less-enabled = true, less в прелоад
			'class'=>'application.extensions.bootstrap.components.Bootstrap', // assuming you extracted bootstrap under extensions
			'debug' => false,
			'cssFile' => 'bootstrap.less.css',
			'coreCss' => false, // Иначе плохо работает Gii 
			'yiiCss' => false,  // Иначе плохо работает Gii 
		),	

		'format' => array('class' => 'DFormatter'),

		'settings' => array('class' => 'DSettingsComponent',
			'config' => array(
					'browserTitle' => 'Заголовок сайта',
					'phone1' => 'Телефон 1',
					'phone2' => 'Телефон 2',
					'email' => 'Email',
				),
			),

		'mail'=>array(
					'class' => 'application.extensions.phpmailer.JPhpMailer',
					'Layout' => 'application.views.layouts.email',
					'fromAddress' => 'studio@deka-web.ru',
					'fromName' => 'Абитон',
				),

		'db'=>array(
			'class' => 'DDbConnection',
			'emulatePrepare' => false,
			'charset' => 'utf8'),

		'authManager' => array(
			'class' => 'DPhpAuthManager',
			'defaultRoles' => array('guest')),

		'errorHandler' => array('errorAction'=>'cp/error'),
		
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),						
			),
		),

		// Снимите комментарий при необходимости
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName' => false,	// .HTACCESS!!!
			'rules'=>array(
				'' => 'site/site/index',					// Ну, и на главную страницу сайта
				'block' => 'site/site/block',					// Ну, и на главную страницу сайта
				'cp' => '/pages/admin/admin',				// Действие по умолчанию для контрольной панели
				'cp/login' => '/users/login/login',			// Действие по умолчанию для контрольной панели
				
				'contacts' => 'site/feedback/form', 		// Обратная связь
				'contacts/sent' => 'site/feedback/sent', 	// Обратная связь

				'site/<controller:(?!pages)\w+>/<action:\w+>' => '/site/<controller>/<action>',
				'site/pages/<action:(?!view)\w+>' => '/site/pages/<action>',

				// Разбираем путь для страницы
				array(
					'class' => 'DPathUrlRule',
					'pathPattern' => '<path:(?!cp|gii).+>',	// Ловим все, что не начинается с cp или gii
					'pattern' => '', 			
					'route' => 'site/pages/view',
					), 	


				'cp/<module:\w+>/<controller:\w+>/<action:\w+>' => '/<module>/<controller>/<action>',
			),
		),
		
	),

	// Обращение: Yii::app()->params['paramName']
	'params' => array(),
), require(dirname(__FILE__) . '/' . CONFIG_FILE));