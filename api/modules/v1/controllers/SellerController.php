<?php

namespace api\modules\v1\controllers;

use yii\db\Query;
use common\models\Seller;
use common\models\Offer;
use api\components\RestUtils;

/**
 * SellerController API (extends \yii\rest\ActiveController)
 * SellerController has all the information about seller (customer) users.
 * @return [status,data,count,[error]]
 * @author Bruno Scholz <brunoscholz@yahoo.de>
 */
class SellerController extends \yii\rest\ActiveController
{
    public $modelClass = 'common\models\Seller';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['create'], $actions['delete']);
        return $actions;
    }

    public function actionIndex()
    {
        $data = RestUtils::getQuery(\Yii::$app->request->get(), Seller::find());

        $models = array('status'=>200,'count'=>0);
        $modelsArray = array();

        //$data->andFilterWhere(['like binary', 'tbl_user.userId', $filter['userId']]);

        foreach ($data->each() as $model)
        {
            $temp = RestUtils::loadQueryIntoVar($model);
            $revs = RestUtils::loadQueryIntoVar($model->reviews);
            $temp['reviews'] = $revs;

            $flwr = RestUtils::loadQueryIntoVar($model->followers);
            $temp['followers'] = $flwr;

            $modelsArray[] = $temp;
        }

        $models['data'] = $modelsArray;
        $models['count'] = count($modelsArray);

        echo RestUtils::sendResult($models['status'], $models);
    }

    public function actionCatalog($id)
    {
        $models = ['status'=>200, 'count'=>0];
        $seller = Seller::findOne($id);

        $modelsArray = [];
        foreach ($seller->offers as $model)
        {
            $temp = RestUtils::loadQueryIntoVar($model);
            $pic = $temp['picture'];
            //unset($temp['seller']);
            $temp['seller'] = null;
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
