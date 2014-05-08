<?php

# ver: 1.0.1

$config = dirname(__FILE__) . '/protected/config/main.php';

$yii = '/Applications/MAMP/bin/Yii/yii-1.1.14/framework/yii.php';

defined('YII_DEBUG') or define('YII_DEBUG',true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

define('CONFIG_FILE', 'main_local.php');

function d($var) {CVarDumper::dump($var, 10, true); echo '<br>';}

require_once($yii);

Yii::createWebApplication($config)->run();
