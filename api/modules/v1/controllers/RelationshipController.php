<?php

namespace api\modules\v1\controllers;

class RelationshipController extends \yii\rest\ActiveController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public $modelClass = 'api\modules\v1\models\Relationship';

    public function behaviors() {
        return [
            [
                'class' => \yii\filters\ContentNegotiator::className(),
                'formats' => [
                    'application/json' => \yii\web\Response::FORMAT_JSON,
                ],
            ],
        ];
    }
}
