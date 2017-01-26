<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['user'],
        ],
        'formatter' => [
			'datetimeFormat' => 'yyyy-MM-dd HH:mm',
			'decimalSeparator' => ',',
			'thousandSeparator' => '.',
			//'realCurrencyCode' => 'BRL',
			'currencyCode' => 'OTK',

		],
        'urlManagerFrontend' => [
            'class' => 'yii\web\urlManager',
            'baseUrl' => 'frontend/web/',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
    ],
];
