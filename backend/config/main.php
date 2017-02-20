<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

//php composer.phar require --prefer-dist drsdre/yii2-wizardwidget "*"

return [
    'id' => 'app-backend',
    'name' => 'OndeTem?!',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'notifications' => [
            'class' => 'machour\yii2\notifications\NotificationsModule',
            // Point this to your own Notification class
            // See the "Declaring your notifications" section below
            'notificationClass' => 'backend\components\Notification',
            // Allow to have notification with same (userId, key, keyId)
            // Default to FALSE
            'allowDuplicate' => false,
            // This callable should return your logged in user Id
            'userId' => function() {
                return \Yii::$app->user->identity->userId;
            },
            'userGroup' => function() {
                return \Yii::$app->user->identity->role;
            },
        ],

        'buyers' => [
            'class' => 'backend\modules\buyers\BuyerModule',
        ],
        'categories' => [
            'class' => 'backend\modules\categories\CategoryModule',
        ],
        'chat' => [
            'class' => 'backend\modules\chat\ChatModule',
        ],
        'favorites' => [
            'class' => 'backend\modules\favorites\FavoriteModule',
        ],
        'follows' => [
            'class' => 'backend\modules\follows\FollowModule',
        ],
        'items' => [
            'class' => 'backend\modules\items\ItemModule',
        ],
        'offers' => [
            'class' => 'backend\modules\offers\OfferModule',
        ],
        'pictures' => [
            'class' => 'backend\modules\pictures\PictureModule',
        ],
        'reviews' => [
            'class' => 'backend\modules\reviews\ReviewModule',
            //'reviewClass' => 'backend\modules\review\models\ReviewFact',
        ],
        'sellers' => [
            'class' => 'backend\modules\sellers\SellerModule',
        ],
    ],
    'defaultRoute' => 'dashboard/index',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'backend\models\User',
            'enableAutoLogin' => true,
            //'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManagerFrontEnd' => [
            'class' => 'yii\web\urlManager',
            'baseUrl' => '/ondetem/frontend/web',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        /*'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
        ],*/
        /*'i18n' => [
            'translations' => [
                'messages' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@backend/messages',
                ]
            ],
        ],*/
    ],
    'params' => $params,
];
