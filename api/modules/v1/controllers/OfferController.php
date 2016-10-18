<?php
 
namespace api\modules\v1\controllers;
 
use yii\rest\ActiveController;
 
/**
 * Offer Controller API
 *
 * @author Bruno Scholz <brunoscholz@yahoo.de>
 */
class OfferController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Offer';

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