<?php

namespace api\modules\v1\controllers;

use yii\db\Query;
use api\modules\v1\models\Buyer;
use api\components\RestUtils;

/**
 * BuyerController API (extends \yii\rest\ActiveController)
 * BuyerController is responsible for present the normal user's info
 * @return [status,data,count,[error]]
 * @author Bruno Scholz <brunoscholz@yahoo.de>
 */
class BuyerController extends \yii\rest\ActiveController
{
    public $modelClass = 'api\modules\v1\models\Buyer';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['create'], $actions['delete']);
        return $actions;
    }

    public function actionIndex()
    {
        $data = RestUtils::getQuery(\Yii::$app->request->get(), Buyer::find());

        $models = array('status'=>200,'count'=>0);
        $modelsArray = array();

        /*->joinwith([
            'user',
            'picture',
            'loyalties'
            ])*/

        //$data->andFilterWhere(['like binary', 'tbl_user.userId', $filter['userId']]);

        foreach ($data->each() as $model)
        {
            $temp = RestUtils::loadQueryIntoVar($model);
            $revs = RestUtils::loadQueryIntoVar($model->reviews);
            $temp['reviews'] = $revs;
            $modelsArray[] = $temp;
        }

        $models['data'] = $modelsArray;
        $models['count'] = count($modelsArray);

        echo RestUtils::sendResult($models['status'], $models);
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
