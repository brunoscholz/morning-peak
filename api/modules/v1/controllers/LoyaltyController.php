<?php

namespace api\modules\v1\controllers;

use yii\db\Query;
use api\modules\v1\models\Loyalty;
use api\components\RestUtils;

/**
 * LoyaltyController API (extends \yii\rest\ActiveController)
 * LoyaltyController has all the informations about balance and transactions made by a given user
 * @return [status,data,count,[error]]
 * @author Bruno Scholz <brunoscholz@yahoo.de>
 */
class LoyaltyController extends \yii\rest\ActiveController
{
    public $modelClass = 'api\modules\v1\models\Loyalty';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['create'], $actions['delete']);
        return $actions;
    }

    public function actionIndex()
    {
        $params = \Yii::$app->request->get();
        $data = RestUtils::getQuery($params, Loyalty::find());

        $data->joinWith([
            'buyer',
            'transaction',
            'token'
        ]);

        $cur = 'COIN';
        if(isset($params['token']) && !empty($params['token']))
            $cur = strtoupper($params['token']);
        
        $data->andWhere(['like', 'tbl_asset_token.name', $cur]);

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
