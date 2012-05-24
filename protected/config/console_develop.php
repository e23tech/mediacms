<?php
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
$params = require(dirname(__FILE__) . DS . 'setting_develop.php');

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'id' => $params['domain'],
	'name'=> $params['sitename'],
    'language' => 'zh_cn',
    'charset' => 'utf-8',
    'timezone' => 'Asia/Shanghai',

    'import' => array(
        'application.models.*',
        'application.extensions.*',
        'application.libs.*',
        'application.helpers.*',
    ),
	'components'=>array(
        'log' => array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'categories'=>'system.db.*',
                ),
            ),
        ),
		'db' => array(
            'class' => 'CDbConnection',
			'connectionString' => 'mysql:host=127.0.0.1; port=3306; dbname=e23_mediacms',
			'username' => 'root',
		    'password' => '123',
		    'charset' => 'utf8',
		    'persistent' => true,
		    'tablePrefix' => 'cd_',
            'enableParamLogging' => true,
            'enableProfiling' => true,
        ),
		'newsdb' => array(
            'class' => 'CDbConnection',
			'connectionString' => 'mysql:host=218.57.134.79; port=3306; dbname=cms_e23',
			'username' => 'search',
		    'password' => 'searche23',
		    'charset' => 'utf8',
		    'persistent' => true,
		    'tablePrefix' => 'v9_',
            'enableParamLogging' => true,
            'enableProfiling' => true,
        ),
	
        'cache' => array(
            'class' => 'CFileCache',
		    'directoryLevel' => 2,
        ),
        'apn' => array(
            'class' => 'CDApnProvider',
            'sandbox' => true,
            'cert' => dirname(__FILE__) . DS . 'develop_ck.pem',
            'pass' => '',
        ),
	),
    'params' => $params,
);