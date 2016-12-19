<?php
// https://morning-peak-11460.herokuapp.com/

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php')
);

use \yii\web\Request;

$frontEndBaseUrl = str_replace('/api/web', '/frontend/web', (new Request)->getBaseUrl());
$backEndBaseUrl = str_replace('/api/web', '/backend/web', (new Request)->getBaseUrl());

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'v1', 'v2'], //, 'docGenerator'
    'modules' => [
        // can be versioned and updated
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class' => 'api\modules\v1\Module',
        ],
        'v2' => [
            'basePath' => '@app/modules/v2',
            'class' => 'api\modules\v2\Module',
        ],
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            //'rules' => include('routes.php'),
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'v2/relationship',
                        'v2/category',
                        'v2/transaction',
                        'v2/offer',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/relationship',
                    'tokens' => [
                        '{id}' => '<relationshipId:\\w+>',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/transaction',
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/loyalty',
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET balance' => 'balance'
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/category',
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/offer',
                    'tokens' => [
                        '{id}' => '<offerId:\\w+>',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/buyer',
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/seller',
                    'extraPatterns' => [
                        'GET catalog/<id:\w+>' => 'catalog',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/action-relationship',
                    'extraPatterns' => [
                        'POST create-review' => 'create-review',
                        'POST create-comment' => 'create-comment',
                        'POST create-follow' => 'create-follow',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/follow-fact',
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/favorite-fact',
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/comment-fact',
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/review-fact',
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/auth-token',
                    'pluralize' => false,
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/auth',
                    'pluralize' => false,
                    'only' => ['signup', 'signin', 'logout', 'forgot-password', 'settings', 'seller-register', 'social-connect'],
                    'extraPatterns' => [
                        'POST signin' => 'signin',
                        'POST signup' => 'signup',
                        'POST settings' => 'settings',
                        'POST seller-register' => 'seller-register',
                        'POST social-connect' => 'social-connect',
                        'POST forgot-password' => 'forgot-password',
                        'GET logout/<id:\w+>' => 'logout',
                        //'DELETE logout/<id:\d+>' => 'logout',
                        //'PUT,PATCH change-password/<id:\d+>' => 'change-password'
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/search',
                    'pluralize' => false
                ]
            ],
        ],
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'response' => [
            'formatters' => [
                \yii\web\Response::FORMAT_JSON => [
                     'class' => 'yii\web\JsonResponseFormatter',
                     'prettyPrint' => YII_DEBUG, // use "pretty" output in debug mode
                     'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                ],
            ],
        ],
        'urlManagerBackEnd' => [
            'class' => 'yii\web\urlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'baseUrl' => $backEndBaseUrl,
        ],
        'urlManagerFrontEnd' => [
            'class' => 'yii\web\urlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'baseUrl' => $frontEndBaseUrl,
        ],
        /*'docGenerator' =>[
            'class' => 'eold\apidocgen\src\ApiDocGenerator',
            'isActive'=>true,                      // Flag to set plugin active
            'versionRegexFind'=>'/(\w+)(\d+)/i',   // regex used in preg_replace function to find Yii api version format (usually 'v1', 'vX') ... 
            'versionRegexReplace'=>'${2}.0.0',     // .. and replace it in Apidoc format (usually 'x.x.x')
            'docDataAlias'=>'@runtime/data_path'   // Folder to save output. make sure is writable. 
        ],*/
    ],
    'params' => $params,
];
