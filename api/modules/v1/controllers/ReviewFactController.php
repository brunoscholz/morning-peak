<?php

namespace api\modules\v1\controllers;

use yii\db\Query;

use common\models\ReviewModel;
use common\models\ReviewFact;
use common\models\Review;

use api\components\RestUtils;
use yii\filters\VerbFilter;

/**
 * ReviewFactController API (extends \yii\rest\ActiveController)
 * ReviewFactController holds all info about reviews
 * @return [status,data,count,[error]]
 * @author Bruno Scholz <brunoscholz@yahoo.de>
 */
class ReviewFactController extends \yii\rest\ActiveController
{
    public $modelClass = 'common\models\ReviewFact';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['create'], $actions['delete']);
        return $actions;
    }

    public function beforeAction($action)
    {
        if (in_array($action->id, ['create'])) {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $data = RestUtils::getQuery(\Yii::$app->request->get(), ReviewFact::find());

        $models = array('status'=>200,'count'=>0);
        $modelsArray = array();

        foreach ($data->each() as $model)
        {
            $temp = RestUtils::loadQueryIntoVar($model);
            unset($temp['reviewId']);

            $rate = $temp['rating'];
            $rating = array();
            $rating['grade'] = $rate - floor($rate/100) * 100;

            $rating['attendance'] = floor(floor($rate/100)/10);
            $rating['price'] = floor($rate/100) - $rating['attendance']*10;

            $temp['rating'] = $rating;
            $modelsArray[] = $temp;
        }

        $models['data'] = $modelsArray;
        $models['count'] = count($modelsArray);

        echo RestUtils::sendResult($models['status'], $models);
    }

    public function actionCreate() {
        $params = \Yii::$app->request->post();
        $models = array('status'=>200,'count'=>0);

        var_dump($params);
        die();

        $review = new ReviewModel();
        if($review->loadAll($params) && $review->save()) {
            //$review->save();
            $models['data'] = RestUtils::loadQueryIntoVar($review);
            $models['credit'] = $review->transaction->amount;
        } else {
            $models['error'] = $review->errorList();
            $models['status'] = 403;
        }

        /*$model = new ReviewFact();
        $model->reviewFactId = RestUtils::generateId();
        $model->actionReferenceId = $act->actionReferenceId;
        $model->buyerId = $params['buyerId'];
        $model->sellerId = $params['sellerId'];
        $model->offerId = $params['offerId'];
        $model->grades = "grades";
        $model->rating = $params['rating'];

        $rev = new Review();
        $rev->reviewId = RestUtils::generateId();
        $rev->title = $params['review']['title'];
        $rev->body = $params['review']['body'];*/

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

    protected function verbs() {
        return [
            'index' => ['GET', 'HEAD'],
            'view' => ['GET', 'HEAD'],
            'create' => ['POST'],
            'update' => ['PUT', 'PATCH'],
            'delete' => ['DELETE'],
        ];
    }

//curl -i -H "Accept:application/json" -H "Content-Type:application/json"  -XPOST "http://localhost:8100/v1/review-facts" -d '{"action":"addReview","offerId":"TDh7O1NJPqfCgoECYnEau","buyerId":"logged","sellerId":"vW8wrgSIKukU78XxxhgGs","review":{"title":"titulo","body":"conteudo do corpo"},"rating":3408}'

/*
http://api.ondetem.tk/v1/review-facts
{
  "action":"addReview",
  "offerId":"TDh7O1NJPqfCgoECYnEau",
  "buyerId":"logged",
  "sellerId":"vW8wrgSIKukU78XxxhgGs",
  "review": {
    "title":"Nada demais",
    "body":"Vou ficar parecendo o rothbard!!!"
  },
  "rating":3408
}
*/
}
