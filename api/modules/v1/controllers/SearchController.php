<?php

namespace api\modules\v1\controllers;

use yii\db\Query;
use common\models\Offer;
use common\models\Seller;
use common\models\Buyer;
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
	public $modelClass = 'common\models\Offer';

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
        foreach ($offerModels->each() as $offer)
        {
            $temp = RestUtils::loadQueryIntoVar($offer);
            $revs = RestUtils::loadQueryIntoVar($offer->reviews);

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
            $temp['avgRating'] = ['qtd' => $i, 'avg' => ($i > 0) ? $sum / $i : 0];
            $offers[] = $temp;
        }

        $sellerModels = RestUtils::getSearch($term, ['name', 'email'], Seller::find());
        $sellers = array();
        foreach ($sellerModels->each() as $seller)
        {
            $temp = RestUtils::loadQueryIntoVar($seller);
            //$temp['reviews'] = RestUtils::loadQueryIntoVar($model->reviews);
            $sellers[] = $temp;
        }

        $buyerModels = RestUtils::getSearch($term, ['name'], Buyer::find());
        $buyers = array();
        foreach ($buyerModels->each() as $buyer)
        {
            $temp = RestUtils::loadQueryIntoVar($buyer);
            $flwr = RestUtils::loadQueryIntoVar($buyer->followers);
            $temp['buyer']['followers'] = $flwr;

            $flwg = RestUtils::loadQueryIntoVar($buyer->following);
            $temp['buyer']['following'] = $flwg;

            $favs = RestUtils::loadQueryIntoVar($buyer->favorites);
            $temp['buyer']['favorites'] = $favs;

            $buyers[] = $temp;
        }

        $models = array('status'=>200,'count'=>0);

        $models['data']['offers'] = ['title' => 'Ofertas', 'list' => $offers, 'icon' => 'ios-add-circle-outline', 'showDetails' => false];
        $models['data']['sellers'] = ['title' => 'Empresas', 'list' => $sellers, 'icon' => 'ios-add-circle-outline', 'showDetails' => false];
        $models['data']['buyers'] = ['title' => 'Usuários', 'list' => $buyers, 'icon' => 'ios-add-circle-outline', 'showDetails' => false];
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
