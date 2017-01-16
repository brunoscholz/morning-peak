<?php

namespace api\modules\v1\controllers;

use yii\db\Query;
use common\models\FavoriteFact;
use common\models\ActionReference;
use api\components\RestUtils;

/**
 * FavoriteFactController API (extends \yii\rest\ActiveController)
 * FavoriteFactController is responsible for present the list of offers followed by an user
 * @return [status,data,count,[error]]
 * @author Bruno Scholz <brunoscholz@yahoo.de>
 */
class FavoriteFactController extends \yii\rest\ActiveController
{
    public $modelClass = 'common\models\FavoriteFact';

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
        $models = array('status'=>200,'count'=>0);

        $act = ActionReference::findByType($params['action']);

        $model = new FavoriteFact();
        $model->favoriteFactId = RestUtils::generateId();
        $model->actionReferenceId = $act->actionReferenceId;
        $model->buyerId = isset($params['buyerId']) ? $params['buyerId'] : null;
        $model->offerId = isset($params['offerId']) ? $params['offerId'] : null;
        $model->status = 'ACT';

        // create loyalty and transaction

        if(!$model->save())
        {
            $models['status'] = 403;
            $models['error'] = $model->getFirstError();
        }
        else
        {
            $models['data'] = 'you have another item in your list';
        }

        //$models['count'] = count($modelsArray);

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
