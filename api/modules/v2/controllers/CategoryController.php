<?php

namespace api\modules\v2\controllers;

use yii\db\Query;
use api\modules\v2\models\Category;
use api\components\SearchForm;
use common\models\Category as CategoryModel;
use api\components\RestUtils;

/**
 * CategoryController API (extends \yii\rest\ActiveController)
 * CategoryController is responsible for present the categories of products and services
 * @return [status,data,count,[error]]
 * @author Bruno Scholz <brunoscholz@yahoo.de>
 */
class CategoryController extends \yii\rest\ActiveController
{
    public $modelClass = 'api\modules\v2\models\Category';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['create'], $actions['delete']);
        return $actions;
    }

    public function actionIndex()
    {
        $cat = new SearchForm();
        $q = $cat->buildQuery(['modelClass'=>'common\models\Category', 'where' => ['name'=>'Cutelaria']]);

        var_dump($q->all());
        die();

        $params = \Yii::$app->request->get();
        $data = RestUtils::getQueryParams($params, $this->modelClass);

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
