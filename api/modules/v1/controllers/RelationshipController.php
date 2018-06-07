<?php

namespace api\modules\v1\controllers;

use yii\db\Query;
use common\models\Relationship;
use api\modules\v1\models\VoucherModel;
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
    public $modelClass = 'common\models\Relationship';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['create'], $actions['delete']);
        return $actions;
    }

    public function actionIndex()
    {
        $data = RestUtils::getQuery(\Yii::$app->request->get(), Relationship::find());

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

    // buyerId
    public function actionVouchers($id)
    {
        $query = Relationship::find();
        $query->joinWith([
            'voucherfact'
        ]);

        $query->andFilterWhere(['like binary', 'buyerId', $id]);
        $query->andFilterWhere(['tbl_voucherfact.status' => 'ACT']);
        $data = $query;

        $models = array('status'=>200,'count'=>0);
        $modelsArray = array();

        foreach ($data->each() as $model)
        {
            $temp = RestUtils::loadQueryIntoVar($model->voucherfact);
            $modelsArray[] = $temp;
        }

        $models['data'] = $modelsArray;
        $models['count'] = count($modelsArray);

        echo RestUtils::sendResult($models['status'], $models);
    }

    public function actionBuyVoucher()
    {
        // make transaction and relationship from user to seller (open tiket - receiveVoucher)
        // next, when using/consuming, make transaction and relationship from seller to ondetem
        $params = \Yii::$app->request->post();
        $models = array('status'=>500);

        $voucher = new VoucherModel();
        if(isset($params['VoucherModel']['voucherFactId']))
        {
            if($voucher->buy($params) && $voucher->save()) {
                $models['status'] = 200;

                $temp = RestUtils::loadQueryIntoVar($voucher->relationship);
                $models['data'] = [$temp];

                //$models['data']['token'] = $auth->token;
                //$auth->sendEmail();
            } else {
                $models['status'] = 404;
                $models['error'] = $voucher->firstError();
            }
        }
        else
        {
            $models['error'] = 'Parâmetros inválidos!';
        }

        echo RestUtils::sendResult($models['status'], $models);
    }

    public function actionConsumeVoucher()
    {
        // next, when using/consuming, make transaction and relationship from seller to ondetem
        $params = \Yii::$app->request->post();
        $models = array('status'=>500);

        $voucher = new VoucherModel();
        if(isset($params['VoucherModel']['voucherFactId']))
        {
            if($voucher->consume($params) && $voucher->save()) {
                $models['status'] = 200;

                $temp = RestUtils::loadQueryIntoVar($voucher->relationship);
                $models['data'] = [$temp];
                //$models['data']['token'] = $auth->token;
                //$auth->sendEmail();
            } else {
                $models['status'] = 404;
                $models['error'] = $voucher->firstError();
            }
        }
        else
        {
            $models['error'] = 'Parâmetros inválidos!';
        }

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
