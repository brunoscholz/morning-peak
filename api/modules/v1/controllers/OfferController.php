<?php

namespace api\modules\v1\controllers;

use yii\db\Query;
use api\modules\v1\models\Offer;
use api\components\RestUtils;

/**
 * Offer Controller API
 *
 * @author Bruno Scholz <brunoscholz@yahoo.de>
 */
class OfferController extends \yii\rest\ActiveController
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
        $data = RestUtils::getQuery($_REQUEST, Offer::find());

        $models = array('status'=>1,'count'=>0);

        $modelsArray = array();
        // batch query with eager loading
        foreach ($data->each() as $model)
        {
            $of = $model->attributes;
            unset($of['itemId'], $of['sellerId'], $of['policyId'], $of['shippingId'], $of['pictureId']);

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
            'seller' => [
                'userId' => 'user',
                'pictureId' => 'picture',
                'reviews',
            ],
            'policy',
            'shipping',
            'item' => [
                'categoryId' => 'category'
            ],
            'picture',
            'reviews'
        ];
    }
}