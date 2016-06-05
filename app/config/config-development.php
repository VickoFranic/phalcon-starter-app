<?php

return [

	'database' => [
		'adapter'     => 'Mysql',
		'host'        => 'localhost',
		'username'    => '',
		'password'    => '',
		'dbname'      => 'database'
	],
	'application' => [
		'controllersDir' 	=> __DIR__ . '/../../app/controllers/',
		'modelsDir'      	=> __DIR__ . '/../../app/models/',
		'viewsDir'       	=> __DIR__ . '/../../app/views/',
		'host'				=> 'http://myDomain.dev'
	],
    'volt' => [
        'path' => __DIR__ . '/../volt/',
        'extension' => '.compiled',
        'separator' => '@',
        'stat' => true
    ],
    'facebook' => [
    	'app_id'				=> 'APP_ID',
    	'app_secret'			=> 'APP_SECRET',
    	'default_graph_version' => 'v2.5',
    ]
];