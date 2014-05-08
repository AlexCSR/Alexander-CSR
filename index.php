<?php

# ver: 1.0.1

$config = dirname(__FILE__) . '/protected/config/main.php';

$yii = dirname(__FILE__) . '/protected/framework/yii.php';

defined('YII_DEBUG') or define('YII_DEBUG',true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

function d($var) {CVarDumper::dump($var, 10, true); echo '<br>';}

require_once($yii);

Yii::createWebApplication($config)->run();
