<?php

namespace api\modules\v1\controllers;

use yii\db\Query;
use common\models\Offer;
use api\components\RestUtils;
use yii\helpers\ArrayHelper;

/**
 * OfferController API (extends \yii\rest\ActiveController)
 * OfferController is the core controller since everything revolves around offers.
 * It returns info about offers with sellers, pictures, items, etc.
 * @return [status,data,count,[error]]
 * @author Bruno Scholz <brunoscholz@yahoo.de>
 */
class OfferController extends \yii\rest\ActiveController
{
    public $modelClass = 'common\models\Offer';

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

        $models = array('status'=>200,'count'=>0);
        $modelsArray = array();

        foreach ($data->each() as $model)
        {
            //var_dump($model);
            //var_dump($model->reviews);
            //var_dump(ArrayHelper::toArray($model, $this->getResponseScope(), true));
            $temp = RestUtils::loadQueryIntoVar($model);
            $revs = RestUtils::loadQueryIntoVar($model->reviews);

            $i = 0;
            $sum = 0;
            $newReviews = array();
            foreach ($revs as $review)
            {
                $rate = $review['rating'];
                $rating = array();
                $rating['grade'] = $rate - floor($rate/100) * 100;

                $rating['attendance'] = floor(floor($rate/100)/10);
                $rating['price'] = floor($rate/100) - $rating['attendance']*10;

                $review['rating'] = $rating;
                unset($review['offer']);
                $newReviews[] = $review;
                $sum += $rating['grade'];
                $i++;
            }
            // let rate = this.rating + this.attendance * 1000 + this.price * 100;
            // let decimal = rate - (Math.floor(rate / 100) * 100);
            // return decimal;

            $temp['reviews'] = $newReviews;
            $temp['avgRating'] = ['qtd' => $i, 'avg' => ($i > 0) ? $sum / $i : 0];

            /*var_dump($temp);

            die();

            $of = $model->attributes;
            unset($of['itemId'], $of['sellerId'], $of['policyId'], $of['shippingId'], $of['pictureId']);

            $of = array_merge($of, RestUtils::loadQueryIntoVar($model, $this->getResponseScope()));*/
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