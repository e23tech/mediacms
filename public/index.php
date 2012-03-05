<?php
define('BETA_WEBROOT', dirname(__FILE__));
defined('BETA_PRODUCT') or define('BETA_PRODUCT', false);
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
YII_DEBUG or error_reporting(0);

$yii = dirname(__FILE__) . '/../library/framework/yii.php';
$short = dirname(__FILE__) . '/../library/shortcut.php';
$config = dirname(__FILE__) . '/../protected/config/' . (BETA_PRODUCT ? 'main_product.php' : 'main_develop.php');

require_once($yii);
require_once($short);

$app = Yii::createWebApplication($config);
$app->run();