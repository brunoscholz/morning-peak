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

            $temp['reviews'] = $newReviews;
            $temp['avgRating'] = ($i > 0) ? $sum / $i : 0;
            $offers[] = $temp;
        }

        $sellerModels = RestUtils::getSearch($term, ['name', 'email'], Seller::find());
        $sellers = array();
        foreach ($sellerModels->each() as $model)
        {
            $temp = RestUtils::loadQueryIntoVar($model);
            //$temp['reviews'] = RestUtils::loadQueryIntoVar($model->reviews);
            $sellers[] = $temp;
        }

        $buyerModels = RestUtils::getSearch($term, ['name'], Buyer::find());
        $buyers = array();
        foreach ($buyerModels->each() as $model)
        {
            $temp = RestUtils::loadQueryIntoVar($model);
            $flwr = RestUtils::loadQueryIntoVar($user->buyer->followers);
            $temp['buyer']['followers'] = $flwr;

            $flwg = RestUtils::loadQueryIntoVar($user->buyer->following);
            $temp['buyer']['following'] = $flwg;

            $favs = RestUtils::loadQueryIntoVar($user->buyer->favorites);
            $temp['buyer']['favorites'] = $favs;

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
