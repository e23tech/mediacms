<?php
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
defined('YII_PRODUCT') or define('YII_PRODUCT', false);
defined('YII_DEBUG') or define('YII_DEBUG', true);
!YII_DEBUG && error_reporting(0);

$short = dirname(__FILE__) . '/../library/shortcut.php';
$define = dirname(__FILE__) . '/config/define.php';
require_once($define);
require_once($short);

// change the following paths if necessary
$yiic = dirname(__FILE__) . '/../library/framework/yiic.php';
$config = dirname(__FILE__).'/config/' . (YII_PRODUCT ? 'console_product.php' : 'console_develop.php');

require_once($yiic);
