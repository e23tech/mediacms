<?php
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
$params = require(dirname(__FILE__) . DS . 'params_product.php');

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'id' => 'waduanzi.com',
	'name'=>'Daily Jokes',
    'language' => 'zh_cn',
    'charset' => 'utf-8',
    'timezone' => 'Asia/Shanghai',

    'import' => array(
        'application.dmodels.*',
        'application.models.*',
        'application.extensions.*',
        'application.libs.*',
    ),
	'components'=>array(
		'db' => array(
            'class' => 'CDbConnection',
			'connectionString' => 'mysql:host=localhost; port=3306; dbname=cd_waduanzi',
			'username' => 'root',
		    'password' => 'cdc_790406',
		    'charset' => 'utf8',
		    'persistent' => true,
		    'tablePrefix' => 'cd_',
//             'enableParamLogging' => true,
//             'enableProfiling' => true,
	        'schemaCacheID' => 'cache',
	        'schemaCachingDuration' => 3600 * 24,    // metadata 缓存超时时间(s)
	        'queryCacheID' => 'cache',
	        'queryCachingDuration' => 60,
        ),
        'cache' => array(
            'class' => 'CFileCache',
		    'directoryLevel' => 2,
        ),
        'apn' => array(
            'class' => 'CDApnProvider',
            'sandbox' => false,
            'cert' => dirname(__FILE__) . DS . 'product_ck.pem',
            'pass' => '',
        ),
	),
    'params' => $params,
);