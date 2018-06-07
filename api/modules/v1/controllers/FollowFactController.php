<?php

namespace api\modules\v1\controllers;

use yii\db\Query;
use api\modules\v1\models\FollowModel;
use common\models\FollowFact;
use common\models\ActionReference;
use api\components\RestUtils;

/**
 * FollowFactController API (extends \yii\rest\ActiveController)
 * FollowFactController is responsible for present the objects followed by an user
 * @return [status,data,count,[error]]
 * @author Bruno Scholz <brunoscholz@yahoo.de>
 */
class FollowFactController extends \yii\rest\ActiveController
{
    public $modelClass = 'api\modules\v1\models\FollowModel';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['create'], $actions['delete']);
        return $actions;
    }

    public function actionIndex()
    {
        $params = \Yii::$app->request->get();
        $q = (array)json_decode($params['q'], true);
        $data = FollowFact::find();

        //$data = RestUtils::getQuery(\Yii::$app->request->get(), FavoriteFact::find());

        $profile = "buyer";
        if(isset($q['profile']) && !empty($q['profile']))
            $profile = $q['profile'];

        // buyer or seller Id
        $id = "";
        if(isset($q['userId']) && !empty($q['userId']))
            $id = isset($q['userId']['test']) ? $q['userId']['value'] : $q['userId'];

        if($profile == "buyer") {
            $data->orWhere(['like binary', 'userId', $id]);
            $data->orWhere(['like binary', 'buyerId', $id]);
        } else {
            // return just followers
            $data->orWhere(['like binary', 'sellerId', $id]);
        }

        $data->orderBy("userId DESC");

        $models = array('status'=>200,'count'=>0);
        $modelsArray = array();

        $followers = [];
        $following = [];
        foreach ($data->each() as $model)
        {
            $temp = RestUtils::loadQueryIntoVar($model);
            if ($profile == "buyer") {
                if ($temp["userId"] == $id)
                    $following[] = $temp;
                else
                    $followers[] = $temp;
            } else {
                $followers[] = $temp;
            }
        }

        $models['data']["followers"] = $followers;
        $models['data']["following"] = $following;
        $models['count'] = count($followers) + count($following);

        echo RestUtils::sendResult($models['status'], $models);
    }

    public function actionCreate() {
        $params = \Yii::$app->request->post();
        $models = array('status'=>200,'count'=>0);

        $follow = new FollowModel();
        //$follow->loadAll($params);

        if($follow->loadAll($params) && $follow->save()) {
            //$follow->save();
            $models['data'] = RestUtils::loadQueryIntoVar($follow->followFact);
            $models['credit'] = $follow->transaction->amount;
        } else {
            $models['status'] = 403;
            $models['error'] = $follow->errorList();
        }

        echo RestUtils::sendResult($models['status'], $models);
    }

    public function actionRemove($id) {
        $params = \Yii::$app->request->post();
        $models = array('status'=>200,'count'=>0);

        $fav = FollowFact::findById($id);

        var_dump($fav);
        var_dump($params);
        die();
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
