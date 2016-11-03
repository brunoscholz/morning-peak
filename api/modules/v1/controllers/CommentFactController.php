<?php

namespace api\modules\v1\controllers;

class CommentFactController extends \yii\rest\ActiveController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public $modelClass = 'api\modules\v1\models\CommentFact';

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
