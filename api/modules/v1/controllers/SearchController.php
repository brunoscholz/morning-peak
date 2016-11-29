<?php

namespace api\modules\v1\controllers;

use yii\db\Query;
use api\modules\v1\models\Offer;
use api\modules\v1\models\Seller;
use api\modules\v1\models\Buyer;
use api\components\RestUtils;
//use api\modules\v1\models\Geography;

/**
 * SearchController API (extends \yii\rest\ActiveController)
 * SearchController returns offers and users that match the search term.
 * @return [status,data,count,[error]]
 * @author Bruno Scholz <brunoscholz@yahoo.de>
 */
class SearchController extends \yii\rest\ActiveController
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
        $searchExact = false;
        $term = "";
        $params = \Yii::$app->request->get();
        if(isset($params['q']) && !empty($params['q']))
            $term = $params['q'];

        if($searchExact)
            $term = explode(" ", $term);

        $fields = ['description', 'keywords', 'item.title'];
        $offerModels = RestUtils::getSearch($term, $fields, Offer::find());
        $offerModels->joinwith([
            'policy',
            'shipping',
            'seller',
            'item'
        ]);

        $offers = array();
        foreach ($offerModels->each() as $model)
        {
            $temp = RestUtils::loadQueryIntoVar($model);
            $temp['reviews'] = RestUtils::loadQueryIntoVar($model->reviews);
            $offers[] = $temp;
        }

        $sellerModels = RestUtils::getSearch($term, ['name', 'email'], Seller::find());
        $sellers = array();
        foreach ($sellerModels->each() as $model)
        {
            $temp = RestUtils::loadQueryIntoVar($model);
            //$temp['reviews'] = RestUtils::loadQueryIntoVar($model->reviews);;
            $sellers[] = $temp;
        }

        $buyerModels = RestUtils::getSearch($term, ['name'], Buyer::find());
        $buyers = array();
        foreach ($buyerModels->each() as $model)
        {
            $temp = RestUtils::loadQueryIntoVar($model);
            //$temp['reviews'] = RestUtils::loadQueryIntoVar($model->reviews);;
            $buyers[] = $temp;
        }

        $models = array('status'=>200,'count'=>0);

        $models['data']['offers'] = $offers;
        $models['data']['sellers'] = $sellers;
        $models['data']['buyers'] = $buyers;
        $models['count'] = count($offers) + count($sellers) + count($buyers);

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
