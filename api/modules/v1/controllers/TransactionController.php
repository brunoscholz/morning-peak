<?php

namespace api\modules\v1\controllers;

use yii\db\Query;
use common\models\Transaction;
use common\models\User;
use common\models\AssetToken;
use api\components\RestUtils;

/**
 * TransactionController API (extends \yii\rest\ActiveController)
 * TransactionController used as timestamp for user actions, holds the amounts of internal coin trades
 * @return [status,data,count,[error]]
 * @author Bruno Scholz <brunoscholz@yahoo.de>
 */
class TransactionController extends \yii\rest\ActiveController
{
    public $modelClass = 'common\models\Transaction';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['create'], $actions['delete']);
        return $actions;
    }

    public function actionIndex()
    {
        $params = \Yii::$app->request->get();
        $q = (array)json_decode($params['q'], true);

        $balance = [];
        if(isset($q['userId']) && !empty($q['userId']))
        {
            $id = isset($q['userId']['test']) ? $q['userId']['value'] : $q['userId'];

            $cur = 'NONE';
            if(isset($params['asset']) && !empty($params['asset']))
                $cur = strtoupper($params['asset']);

            if($cur !== 'NONE')
                $tokens = AssetToken::find()->where(['like', 'name', $cur])->all();
            else
                $tokens = AssetToken::find()->all();

            foreach ($tokens as $token)
            {
                $result = RestUtils::getBalance($id, $token->name, Transaction::find());
                $balance[$token->name] = (float)$result['TotalBlue'] - (float)$result['TotalRed'];
            }
        }

        // $newParams = $params;
        // $newParams['q'] = str_replace("userId", "recipientId", $newParams['q']);
        $data = Transaction::find();
        $data->joinWith([
            'token'
        ]);

        $id = "";
        if(isset($q['userId']) && !empty($q['userId']))
            $id = isset($q['userId']['test']) ? $q['userId']['value'] : $q['userId'];
        
        if ($id != "") {
            $data->orWhere(['like binary', 'recipientId', $id]);
            $data->orWhere(['like binary', 'senderId', $id]);
        }

        $cur = 'none';
        if(isset($params['asset']) && !empty($params['asset']))
            $cur = strtoupper($params['asset']);
        
        if($cur !== 'none')
            $data->andWhere(['like', 'tbl_asset_token.name', $cur]);

        $data->orderBy("tbl_transaction.timestamp DESC");

        $models = array('status'=>200,'count'=>0);
        $modelsArray = array();

        // var_dump($data->createCommand()->rawsql);
        // die();

        foreach ($data->each() as $model)
        {
            $temp = RestUtils::loadQueryIntoVar($model);
            $modelsArray[] = $temp;
        }

        $models['data']['transactions'] = $modelsArray;
        $models['data']['balance'] = $balance;
        $models['count'] = count($modelsArray);

        echo RestUtils::sendResult($models['status'], $models);
    }

    public function actionCreate()
    {
        $params = \Yii::$app->request->post();

        var_dump($params);
        die();

        $model = new Transaction();
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
