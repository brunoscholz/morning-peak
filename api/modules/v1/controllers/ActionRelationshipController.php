<?php

namespace api\modules\v1\controllers;

use yii\db\Query;
use common\models\ReviewFact;
use common\models\CommentFact;
use common\models\FollowFact;
use common\models\Review;
use common\models\Comment;
use common\models\Transaction;
use common\models\ActionRelationship;
use api\components\RestUtils;

/**
 * ActionRelationshipController API (extends \yii\rest\ActiveController)
 * ActionRelationshipController has the goal of register and create the "social" actions.
 * - review, comment, and follow
 *
 * @return [status,data,count,[error]]
 * @author Bruno Scholz <brunoscholz@yahoo.de>
 */
class ActionRelationshipController extends \yii\rest\ActiveController
{
    public $modelClass = 'common\models\ActionRelationship';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['create'], $actions['delete']);
        return $actions;
    }

    public function actionIndex()
    {
        $data = RestUtils::getQuery(\Yii::$app->request->get(), ActionRelationship::find());

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
