<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'AVTOMIR Control Panel',

	'preload'=>['log',
	],

	'import'=>[
		'application.models.*',
		'application.models.db.*',
		'application.models.form.*',
		'application.models.interface.*',
		'application.components.*',
		'application.components.behavior.*',
		'application.extensions.*',
		'application.extensions.KEmail.*',
        'application.vendors.phpexcel.PHPExcel.*',
	],

	'modules'=>[
		'access', // user operations: auth, create, login, etc
		'price', // price list
		'admin', // admin options
		'warehouse',
        'finance',
        'invoice',
		'mnt',

		'rbac'=>[
			'class'=>'application.modules.rbacui.RbacuiModule',
			'userClass' => 'DbUser',
			'userIdColumn' => 'u_id',
			'userNameColumn' => 'u_login',
			'rbacUiAdmin' => true,
			'rbacUiAssign' => true,
		],
		
		'gii'=>[
			'class'=>'system.gii.GiiModule',
			'password'=>'gii123',
			'ipFilters'=>['127.0.0.1','::1'],
			],
		
	],

	'components'=>[
	
		// user component
		'user'=>[
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'loginUrl' => ['access/user/login'],
		],
		
		'authManager'=>array(
			'class' => 'CDbAuthManager',
			'defaultRoles'=>['guest'],
		),
/*		
		// email send component
		'email'=>[
			'class'=>'KEmail',
			'host_name'=>'smtp.gmail.com',
			'user'=>'',
			'password'=>'',
			'host_port'=>465,
			'ssl'=>'true',
		],	
*/	
		'cache'=>[
            'class'=>'system.caching.CFileCache',
        ],
		
		// settings component
		'settings'=>[
			'class'				=> 'DbSettings',
			'cacheComponentId'	=> 'cache',
			'cacheId'			=> 'global_website_settings',
			'cacheTime'			=> 84000,
			'tableName'			=> 'parameter',
			'dbComponentId'		=> 'db',
		],	
		
		// urlmanager
		'urlManager'=>[
			'urlFormat'=>'path',
            'showScriptName'=>false,
			'rules'=>[
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				'<module:\w+>/<controller:\w+>/<action:\w+>'=>'<module>/<controller>/<action>',
			],
		],

		'db'=>require(dirname(__FILE__).'/database.php'),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),

		// log component
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				[
					'class'=>'CFileLogRoute',
//					'levels'=>'error, warning, trace, profile, info',
					'levels'=>'error',
				],
			//	[	'class'=>'CWebLogRoute',
			//		'levels'=>'error, warning, trace, profile, info',
			//	],
			  [
				'class'=>'XWebDebugRouter',
				'config'=>'alignLeft, opaque, runInDebug, fixedPos, collapsed, yamlStyle, dbProfiling',
				'levels'=>'error, warning, trace, profile, info',
				'allowedIPs'=>array('127.0.0.1','::1','192.168.1.54','192\.168\.1[0-5]\.[0-9]{3}'),
			  ],				
			),
		),

	], // components

	// using Yii::app()->params['paramName']
	'params'=>[
		// this is used in contact page
		'adminEmail'=>'a77x77@gmail.com',
		// user for proper login/password select for VIVAT websevice
        'dev'=>require(dirname(__FILE__).'/specific/dev.php'),
		//'dev'=>true,
	],
	
);
