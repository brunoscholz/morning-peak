<?php

namespace api\modules\v1\controllers;

use yii\db\Query;
use api\modules\v1\models\ReviewFact;
use api\modules\v1\models\CommentFact;
use api\modules\v1\models\FollowFact;
use api\modules\v1\models\Review;
use api\modules\v1\models\Comment;
use api\modules\v1\models\Transaction;
use api\modules\v1\models\ActionRelationship;
use api\components\RestUtils;

class ActionRelationshipController extends \yii\rest\ActiveController
{
    public $modelClass = 'api\modules\v1\models\ActionRelationship';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['create'], $actions['delete']);
        return $actions;
    }

    public function actionIndex()
    {
        $data = RestUtils::getQuery(\Yii::$app->request->get(), ActionRelationship::find());

        $models = array('status'=>1,'count'=>0);
        $modelsArray = array();

        foreach ($data->each() as $model)
        {
            $temp = RestUtils::loadQueryIntoVar($model);
            $modelsArray[] = $temp;
        }

        $models['data'] = $modelsArray;
        $models['count'] = count($modelsArray);

        RestUtils::setHeader(200);
        echo json_encode($models, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    public function actionCreateReview()
    {
        $params = \Yii::$app->request->post();

        $reviewFact = new ReviewFact();
        $review = new Review();
        var_dump($reviewFact);
        die();
        //$ar = new ActionRelationship();
        //$tx = new Transaction();
    }

    public function actionCreateComment()
    {
        $params = \Yii::$app->request->post();

        var_dump($params);
        die();

        //$ar = new ActionRelationship();
        //$tx = new Transaction();
        $commentFact = new CommentFact();
        $comment = new Comment();
    }

    public function actionCreateFollow()
    {
        $params = \Yii::$app->request->post();

        var_dump($params);
        die();

        //$ar = new ActionRelationship();
        //$tx = new Transaction();
        $followFact = new FollowFact();
    }

    public function behaviors() {
        return [
            [
                'class' => \yii\filters\ContentNegotiator::className(),
                'formats' => [
                    'application/json' => \yii\web\Response::FORMAT_JSON,
                ],
            ],
        ];
    }
}
