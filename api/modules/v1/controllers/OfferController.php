<?php

namespace api\modules\v1\controllers;

use yii\db\Query;
use api\modules\v1\models\Offer;
use api\components\RestUtils;
use yii\helpers\ArrayHelper;

/**
 * Offer Controller API
 *
 * @author Bruno Scholz <brunoscholz@yahoo.de>
 */
class OfferController extends \yii\rest\ActiveController
{
    public $modelClass = 'api\modules\v1\models\Offer';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['create'], $actions['delete']);
        return $actions;
    }

    public function actionIndex()
    {
        $data = RestUtils::getQuery(\Yii::$app->request->get(), Offer::find());

        $data->joinWith([
            'item'
        ]);

        $data->select([
            'tbl_offer.*',
            'tbl_item.itemId as it_itemId',
            'tbl_item.sku',
            'tbl_item.categoryId',
            'tbl_item.description as it_description',
            'tbl_item.title as it_title',
            'tbl_item.keywords as it_keywords',
            'tbl_item.photoSrc as it_photoSrc',
            'tbl_item.status as it_status',
        ]);

        //print_r($data->createCommand()->getRawSql());

        $models = array('status'=>1,'count'=>0);
        $modelsArray = array();

        foreach ($data->each() as $model)
        {
            //var_dump($model);
            //var_dump($model->reviews);
            //var_dump(ArrayHelper::toArray($model, $this->getResponseScope(), true));
            $temp = RestUtils::loadQueryIntoVar($model);
            $revs = RestUtils::loadQueryIntoVar($model->reviews);
            $temp['reviews'] = $revs;
            /*var_dump($temp);

            die();

            $of = $model->attributes;
            unset($of['itemId'], $of['sellerId'], $of['policyId'], $of['shippingId'], $of['pictureId']);

            $of = array_merge($of, RestUtils::loadQueryIntoVar($model, $this->getResponseScope()));*/
            $modelsArray[] = $temp;
        }

        $models['data'] = $modelsArray;
        $models['count'] = count($modelsArray);

        RestUtils::setHeader(200);
        echo json_encode($models, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
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