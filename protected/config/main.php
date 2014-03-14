<?php

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name' => 'Life women Style',

	'preload'=>array('log'),

    	'language' => 'ru',
	'sourceLanguage' => 'ru_ru',
	'charset' => 'utf-8',
	'defaultController'=>'site',

	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.extensions.jtogglecolumn.*', 
        //'application.extensions.email.*',
	),

	'components'=>array(
        //'dateFormatter'=>array('class'=>'CDateFormatter', 'params'=>array('ru')),
	     	'request'=>array(
        	    'enableCsrfValidation'=>true,
        	),
        
	        'bootstrap' => array(
			'class' => 'ext.bootstrap.components.Bootstrap',
			'responsiveCss' => true,
		),
		'user'=>array(            
			'allowAutoLogin' => true,
            		'loginUrl' => array('site/login'),
		),				
        	'cache' => array(
            		'class' => 'system.caching.CFileCache',
	         ),

	        'email'=>array(
	            'class'=>'application.extensions.email.Email',
        	    'delivery'=>'php', //Will use the php mailing function.
        	    //May also be set to 'debug' to instead dump the contents of the email into the view
        	),

        	'authManager' => array(
        	    // Роль по умолчанию. Все, кто не админы, модераторы и юзеры — гости.
	            'defaultRoles' => array('guest'),
        	    'showErrors' => YII_DEBUG,
        	),

		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'urlSuffix'=>'.html',
			'rules'=>array(	
				'gii/'=>'gii',
				'adm/'=>'adm/default/index',
				'adm/<controller:\w+>/<action:\w+>'=>'adm/<controller>/<action>',
				'<tl>_<id:\d+>'=>'category/view',
				'pages/<sys>'=>'pages/view',
				's/<action:\w+>'=>'sugg/<action>',
				'form_enter'=>'site/login',
				'tests'=>'test/index',
				'test<test_id:\d+>_a<ans:\d+>'=>'test/start',
				'testpage'=>'test/t',
				'<action>'=>'site/<action>',				
			),
		),	 
		
				
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=life',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '123',
			'charset' => 'utf8',
			'tablePrefix'=>'ls_',
			'queryCachingDuration'=>true,
		    	'autoConnect' => false,
		       	'schemaCachingDuration' => 3600,
		),
		
		'errorHandler'=>array(
		    	'errorAction'=>'site/error',
		),
		
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			/*array(
		            'class'=>'CEmailLogRoute',
		            'levels'=>'error, warning',
		            'emails'=>'dimanok88@mail.ru',
		        ),*/
		        /*array(
		            'class' => 'CWebLogRoute',
		            'showInFireBug' => true, // firefox & chrome
		        ), */
			),
		),	
	),

    'modules'=>array(
        'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>false,
        ),
        'adm'=>array(
            'layout'=> 'column2',
            'defaultController'=>'category',
        ),
    ),

	//'catchAllRequest' => array('m/index'),
    	//'onBeginRequest'=>create_function('$event', 'return ob_start("ob_gzhandler");'),
	//'onEndRequest'=>create_function('$event', 'return ob_end_flush();'),

	'params' => array(
        'uploadDir' => '/resources/upload/',
        'mainlink'=>'www.moneywomens.ru',
        'imgThumbWidth' => '350',
        'imgThumbHeight' => '150',
        'imgMiniWidth' => '100',
        'imgMiniHeight' => '80',
        'imgWidth' => '480',
        'imgHeight' => '320',

        'countItemsByPage' => '50',
        'countNewsByPage' => '2',
        'countNewsForIndex' => '3',

        'cacheListTime' => '1',
	),

);

