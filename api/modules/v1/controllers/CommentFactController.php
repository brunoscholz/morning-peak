<?php

namespace api\modules\v1\controllers;

use yii\db\Query;
use common\models\CommentFact;
use api\components\RestUtils;

/**
 * CommentFactController API (extends \yii\rest\ActiveController)
 * CommentFactController is responsible for present comments for a given review
 * @return [status,data,count,[error]]
 * @author Bruno Scholz <brunoscholz@yahoo.de>
 */
class CommentFactController extends \yii\rest\ActiveController
{
    public $modelClass = 'common\models\CommentFact';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['create'], $actions['delete']);
        return $actions;
    }

    public function actionIndex()
    {
        $data = RestUtils::getQuery(\Yii::$app->request->get(), CommentFact::find());

        $models = array('status'=>200,'count'=>0);
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

        echo RestUtils::sendResult($models['status'], $models);
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
