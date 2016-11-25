<?php

namespace api\modules\v1\controllers;

use yii\db\Query;
use api\modules\v1\models\CommentFact;
use api\components\RestUtils;

class CommentFactController extends \yii\rest\ActiveController
{
    public $modelClass = 'api\modules\v1\models\CommentFact';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['create'], $actions['delete']);
        return $actions;
    }

    public function actionIndex()
    {
        $data = RestUtils::getQuery(\Yii::$app->request->get(), CommentFact::find());

        $models = array('status'=>1,'count'=>0);
        $modelsArray = array();

        foreach ($data->each() as $model)
        {
            $temp = RestUtils::loadQueryIntoVar($model);
            unset($temp['reviewFactId']);
            // $revs = RestUtils::loadQueryIntoVar($model->reviews);
            // $temp['reviews'] = $revs;
            $modelsArray[] = $temp;
        }

        $models['data'] = $modelsArray;
        $models['count'] = count($modelsArray);

        RestUtils::setHeader(200);
        echo json_encode($models, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    public function actionCreate()
    {
        $params = \Yii::$app->request->post();

        var_dump($params);
        die();

        $model = new CommentFact();
    }

    public function behaviors() {
        return
        [
            [
                'class' => \yii\filters\ContentNegotiator::className(),
                'formats' => [
                    'application/json' => \yii\web\Response::FORMAT_JSON,
                ],
            ],
        ];
    }
}
