<?php
define('BETA_CONFIG_ROOT', dirname(__FILE__));
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
define('BETA_YES', 1);
define('BETA_NO', 0);

$dbconfig = array(
    'dbHost' => '127.0.0.1',
    'dbPort' => '3306',
    'dbName' => 'e23_mediacms',
    'dbUser' => 'root',
    'dbPassword' => '123',
    'tablePrefix' => 'cd_',
);

try {
    $params = require(BETA_CONFIG_ROOT . DS . 'params.php');
    $defaultSetting = require(BETA_CONFIG_ROOT . DS . 'setting_develop.php');
    $params = array_merge($defaultSetting, $params);
}
catch (Exception $e) {
    echo $e->getMessage();
    exit(0);
}

$dbconfig = require($params['dataPath'] . DS . 'db.config.php');

return array(
    'id' => $params['domain'],
    'name' => $params['sitename'],
    'basePath' => BETA_CONFIG_ROOT . DS . '..',
    'charset' => 'utf-8',
    'language' => $params['language'],
    'layout' => 'main',
    'timezone' => $params['timezone'],

    'import' => array(
		'application.models.*',
		'application.components.*',
        'application.extensions.*',
        'application.helpers.*',
        'application.libs.*',
        'application.widgets.*',
        'application.apis.*',
	),
        
    'modules' => array(
        'admin' => array(
            'layout' => 'main',
        ),
    ),
    'preload' => array('log'),
    'components' => array(
        'log' => array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'categories'=>'system.db.*',
                ),
                /* array(
                    'class'=>'CWebLogRoute',
                    'levels'=>'trace,info,error,notic',
                    'categories'=>'system.db.*',
                ), */
            ),
        ),
        'user' => array(
            'allowAutoLogin' => true,
            'loginUrl' => array('site/login'),
            'returnUrl' => array('site/index')
        ),
        'db' => array(
            'class' => 'CDbConnection',
			'connectionString' => sprintf('mysql:host=%s; port=%s; dbname=%s', $dbconfig['dbHost'], $dbconfig['dbPort'], $dbconfig['dbName']),
			'username' => $dbconfig['dbUser'],
		    'password' => $dbconfig['dbPassword'],
		    'charset' => 'utf8',
		    'persistent' => true,
		    'tablePrefix' => $dbconfig['tablePrefix'],
            'enableParamLogging' => true,
            'enableProfiling' => true,
// 		    'schemaCacheID' => 'cache',
// 		    'schemaCachingDuration' => 3600 * 24,    // metadata 缓存超时时间(s)
// 		    'queryCacheID' => 'cache',
// 		    'queryCachingDuration' => 60,
        ),
        'cache' => array(
            'class' => 'CFileCache',
            'directoryLevel' => 2,
        ),
        'assetManager' => array(
            'basePath' => $params['resourceBasePath'] . 'assets',
            'baseUrl' => $params['resourceBaseUrl'] . 'assets',
        ),
        'themeManager' => array(
            'basePath' => BETA_CONFIG_ROOT . DS . '..' . DS . '..' . DS . 'themes',
            'baseUrl' => $params['themeResourceBaseUrl'],
        ),
        'session' => array(
            'autoStart' => true,
            'cookieParams' => array(
                'lifetime' => $params['autoLoginDuration'],
            ),
        ),
        'widgetFactory'=>array(
            'enableSkin'=>true,
        ),
        'authManager' => array(
            'class' => 'CDbAuthManager',
            'assignmentTable' => $dbconfig['tablePrefix'] . 'auth_assignment',
            'itemChildTable' => $dbconfig['tablePrefix'] . 'auth_itemchild',
            'itemTable' => $dbconfig['tablePrefix'] . 'auth_item',
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
		    'showScriptName' => false,
            'cacheID' => 'cache',
            'rules' => array(
                'page/<page:\d+>' => 'site/index',
                '' => 'site/index',
                '<id:\d+>' => 'post/show',
                '<_a:(login|signup|logout)>' => 'site/<_a>',
                '<_c:(category|topic)>/<id:\d+>-page-<page:\d+>' => '<_c>/posts',
                '<_c:(category|topic)>/<id:\d+>' => '<_c>/posts',
                'topics' => 'topic/list',
                'tag/<name:[\w\d\s\%]+>' => 'tag/posts',
            ),
        ),
    ),

    'params' => $params,
);
