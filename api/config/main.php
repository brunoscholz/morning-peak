<?php
// https://morning-peak-11460.herokuapp.com/

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        // can be versioned and updated
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class' => 'api\modules\v1\Module',
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
            'rules' => [
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
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/action-relationship',
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/follow-fact',
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
                    'controller' => 'v1/auth',
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/search',
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
    ],
    'params' => $params,
];
