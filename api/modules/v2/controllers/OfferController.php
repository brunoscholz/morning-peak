<?php

namespace api\modules\v2\controllers;

use yii\db\Query;
use api\modules\v2\models\OfferModel;
use api\components\Controller;
use api\components\RestUtils;
use api\components\Serializer;

/**
 * OfferController API (extends \yii\rest\ActiveController)
 * OfferController is the core controller since everything revolves around offers.
 * It returns info about offers with sellers, pictures, items, etc.
 * @return [status,data,count,[error]]
 * @author Bruno Scholz <brunoscholz@yahoo.de>
 */
class OfferController extends Controller
{
    public $modelClass = 'common\models\Offer';
    public $searchFormClass = 'api\modules\v2\models\OfferModel';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['create'], $actions['delete']);
        return $actions;
    }

    public function actionIndex()
    {
        $models = array('status'=>200,'count'=>0);
        $searchForm = new $this->searchFormClass();
        $get = \Yii::$app->request->get();

        // $data = RestUtils::getQuery($get, \common\models\Offer::find());
        // var_dump($data->createCommand()->rawsql);

        $query = $searchForm->search($get);

        $queryCount = clone $query;
        //$countAll = (int) $queryCount->limit(-1)->offset(-1)->orderBy([])->count('*');

        //$data = $query->all();
        //$countCurrent = count($models);

        $modelsArray = array();
        foreach ($query->each() as $model)
        {
            //var_dump($model);
            //var_dump($model->reviews);
            //var_dump(ArrayHelper::toArray($model, $this->getResponseScope(), true));
            $temp = (new Serializer())->serializeModels($model);
            $revs = (new Serializer())->serializeModels($model->reviews);

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
            // let rate = this.rating + this.attendance * 100 + this.price * 10;
            // let decimal = rate - (Math.floor(rate / 100) * 100);
            // return decimal;

            $temp['reviews'] = $newReviews;
            $temp['avgRating'] = ['qtd' => $i, 'avg' => ($i > 0) ? $sum / $i : 0];

            $modelsArray[] = $temp;
        }

        $models['data'] = $modelsArray;
        $models['count'] = count($modelsArray);

        echo RestUtils::sendResult($models['status'], $models);
    }
}
