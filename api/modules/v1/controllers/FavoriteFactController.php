<?php

namespace api\modules\v1\controllers;

use yii\db\Query;
use api\modules\v1\models\FavoriteFact;
use api\components\RestUtils;

/**
 * FavoriteFactController API (extends \yii\rest\ActiveController)
 * FavoriteFactController is responsible for present the list of offers followed by an user
 * @return [status,data,count,[error]]
 * @author Bruno Scholz <brunoscholz@yahoo.de>
 */
class FavoriteFactController extends \yii\rest\ActiveController
{
    public $modelClass = 'api\modules\v1\models\FavoriteFact';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['create'], $actions['delete']);
        return $actions;
    }

    public function actionIndex()
    {
        $data = RestUtils::getQuery(\Yii::$app->request->get(), FavoriteFact::find());

        /*$data->joinWith([
            'buyer',
            'offer'
        ]);*/

        $models = array('status'=>200,'count'=>0);
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

    public function actionCreate() {
        $params = \Yii::$app->request->post();

        var_dump($params);
        die();

        $model = new FavoriteFact();
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
