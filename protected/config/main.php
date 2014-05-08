<?php

define ('SITE_DIR', dirname(__FILE__) . '/../../');

return array(
	'basePath' => SITE_DIR . 'protected/',
	'name' => 'HTML',
	'language' => 'ru',
	'defaultController' => 'index',
	'viewPath' => 'views',
	
	// preloading 'log' component
	'preload'=>array('log', 'settings'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	// application components
	'components'=>array(

		// Снимите комментарий при необходимости
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName' => false,	// .HTACCESS!!!
			'rules'=>array(
				'<tpl:\w+>' => '/index/index',
			),
		),
	),

	// Обращение: Yii::app()->params['paramName']
	'params' => array(),
);