<?php

namespace api\modules\v1\controllers;

use yii\db\Query;
use api\modules\v1\models\Category;
use api\components\RestUtils;

class CategoryController extends \yii\rest\ActiveController
{
    public $modelClass = 'api\modules\v1\models\Category';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['create'], $actions['delete']);
        return $actions;
    }

    public function actionIndex()
    {
        $data = RestUtils::getQuery($_REQUEST, Category::find());

        $models = array('status'=>1,'count'=>0);
        $modelsArray = array();

        /*if(isset($filter['parentId']))
            $query->andFilterWhere(['like', 'parentId', $filter['parentId']]);
        if(isset($filter['categoryId']))
            $query->andFilterWhere(['like', 'categoryId', $filter['categoryId']]);
        if(isset($filter['name']))
            $query->andFilterWhere(['like', 'name', $filter['name']]);*/

        foreach ($data->each() as $model)
        {
            $of = $model->attributes;
            unset($of['userId'], $of['pictureId']);

            $of = array_merge($of, RestUtils::loadQueryIntoVar($model, $this->getResponseScope()));
            $modelsArray[] = $of;
        }

        $models['data'] = $modelsArray;
        $models['count'] = count($modelsArray);

        RestUtils::setHeader(200);
        echo json_encode($models, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
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

    function getResponseScope() {
        return [
            
        ];
    }
}
