<?php

namespace api\modules\v1\controllers;

use yii\db\Query;
use api\modules\v1\models\Relationship;
use api\components\RestUtils;

/**
 * RelationshipController API (extends \yii\rest\ActiveController)
 * RelationshipController holds information about everything done by a user:
 * visit page, marked offer, share, buy, sell, etc.
 * @return [status,data,count,[error]]
 * @author Bruno Scholz <brunoscholz@yahoo.de>
 */
class RelationshipController extends \yii\rest\ActiveController
{
    public $modelClass = 'api\modules\v1\models\Relationship';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['create'], $actions['delete']);
        return $actions;
    }

    public function actionIndex()
    {
        $data = RestUtils::getQuery(\Yii::$app->request->get(), Relationship::find());

        $models = array('status'=>1,'count'=>0);
        $modelsArray = array();

        foreach ($data->each() as $model)
        {
            $temp = RestUtils::loadQueryIntoVar($model);
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

        $model = new Relationship();
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
