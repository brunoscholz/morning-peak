<?php

namespace api\modules\v1\controllers;

use yii\db\Query;
use api\modules\v1\models\FollowModel;
use common\models\FollowFact;
use common\models\ActionReference;
use api\components\RestUtils;

/**
 * FollowFactController API (extends \yii\rest\ActiveController)
 * FollowFactController is responsible for present the objects followed by an user
 * @return [status,data,count,[error]]
 * @author Bruno Scholz <brunoscholz@yahoo.de>
 */
class FollowFactController extends \yii\rest\ActiveController
{
    public $modelClass = 'api\modules\v1\models\FollowModel';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['create'], $actions['delete']);
        return $actions;
    }

    public function actionIndex()
    {
        $data = RestUtils::getQuery(\Yii::$app->request->get(), FollowFact::find());

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
        $models = array('status'=>200,'count'=>0);

        $follow = new FollowModel();
        $follow->loadAll($params);

        if($follow->loadAll($params) && $follow->save()) {
            //$follow->save();
            $models['data'] = RestUtils::loadQueryIntoVar($follow->followFact);
            $models['credit'] = $follow->transaction->amount;
        } else {
            $models['status'] = 403;
            $models['error'] = $follow->errorList();
        }

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
