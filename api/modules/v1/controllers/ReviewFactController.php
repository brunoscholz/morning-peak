<?php

namespace api\modules\v1\controllers;

use yii\db\Query;
use api\modules\v1\models\ReviewFact;
use api\modules\v1\models\Review;
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
    public $modelClass = 'api\modules\v1\models\ReviewFact';

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
        //print_r(\Yii::$app->request->post());

        $params = \Yii::$app->request->post();

        $model = new ReviewFact();

        $model->reviewFactId = RestUtils::generateId();
        $model->actionId = 1;
        $model->buyerId = "n6cXcvhdOKc8oog48uBDb";
        $model->sellerId = $params['sellerId'];
        $model->offerId = $params['offerId'];
        $model->grades = "grades";
        $model->rating = $params['rating'];

        $rev = new Review();
        $rev->reviewId = RestUtils::generateId();
        $rev->title = $params['review']['title'];
        $rev->body = $params['review']['body'];

        $models = array('status'=>1,'count'=>0);

        if(!$rev->validate()) {
            $models['data']['review'] = $rev->getErrors();
            $models['status'] = 500;
            echo RestUtils::sendResult($models['status'], $models);
            die();
        }
        
        if($rev->save())
            $models['data']['review'] = 'saved';

        $model->reviewId = $rev->reviewId;
        if(!$model->validate()) {
            $models['data']['reviewFact'] = $model->getErrors();
            $models['status'] = 500;
            echo RestUtils::sendResult($models['status'], $models);
            die();
        }

        if($model->save()) {
            $models['data']['reviewFact'] = 'saved';
            $models['status'] = 1;
        }

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
