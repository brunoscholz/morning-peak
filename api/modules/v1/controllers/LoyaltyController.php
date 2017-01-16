<?php

namespace api\modules\v1\controllers;

use yii\db\Query;
use common\models\Loyalty;
use common\models\AssetToken;
use api\components\RestUtils;

/**
 * LoyaltyController API (extends \yii\rest\ActiveController)
 * LoyaltyController has all the informations about balance and transactions made by a given user
 * @return [status,data,count,[error]]
 * @author Bruno Scholz <brunoscholz@yahoo.de>
 */
class LoyaltyController extends \yii\rest\ActiveController
{
    public $modelClass = 'common\models\Loyalty';

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
                
                $result = RestUtils::getBalance($id, $token->name, Loyalty::find());
                $balance[$token->name] = (float)$result['TotalBlue'] - (float)$result['TotalRed'];
            }
        }

        $data->joinWith([
            'transaction',
            'token'
        ]);

        $cur = 'none';
        if(isset($params['asset']) && !empty($params['asset']))
            $cur = strtoupper($params['asset']);
        
        if($cur !== 'none')
            $data->andWhere(['like', 'tbl_asset_token.name', $cur]);

        $data->orderBy("tbl_transaction.timestamp DESC");

        $models = array('status'=>200,'count'=>0);
        $modelsArray = array();

        foreach ($data->each() as $model)
        {
            $temp = RestUtils::loadQueryIntoVar($model);
            $modelsArray[] = $temp;
        }

        $models['data']['loyalties'] = $modelsArray;
        $models['data']['balance'] = $balance;
        $models['count'] = count($modelsArray);

        echo RestUtils::sendResult($models['status'], $models);
    }

    public function actionBalance()
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
                $result = RestUtils::getBalance($id, $token->name, Loyalty::find());
                $balance[$token->name] = (float)$result['TotalBlue'] - (float)$result['TotalRed'];
            }
        }

        $models = array('status'=>200,'count'=>0);
        $modelsArray = array();

        $models['data'] = [$balance];
        $models['count'] = count($modelsArray);

        echo RestUtils::sendResult($models['status'], $models);

        //$sum = $query->sum('transaction.amount');

        /*
        echo $sum;
        select
            sum(case when senderId LIKE BINARY 'zZN6prD6rzxEhg8sDQz1j' then `amount` else 0 end) as TotalRed,
            sum(case when recipientId LIKE BINARY 'zZN6prD6rzxEhg8sDQz1j' then `amount` else 0 end) as TotalBlue
        from `tbl_transaction`
        select
            sum(case when `tbl_transaction`.`senderId` LIKE BINARY 'zZN6prD6rzxEhg8sDQz1j' then `tbl_transaction`.`amount` else 0 end) as TotalRed,
            sum(case when `tbl_transaction`.`recipientId` LIKE BINARY 'zZN6prD6rzxEhg8sDQz1j' then `tbl_transaction`.`amount` else 0 end) as TotalBlue
        from `tbl_loyalty`
            LEFT JOIN `tbl_transaction` ON `tbl_loyalty`.`transactionId` = `tbl_transaction`.`transactionId`
        where `tbl_transaction`.`senderId` NOT LIKE `tbl_transaction`.`recipientId`*/
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
