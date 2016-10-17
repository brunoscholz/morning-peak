<?php

namespace backend\controllers;

use Yii;
use backend\models\Seller;
use backend\models\Offer;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class DashboardController extends Controller
{
	public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        /*$dataProvider = new ActiveDataProvider([
            'query' => Seller::find(),
        ]);*/

        $data = Seller::find()->one();

        return $this->render('index', [
            'dataProvider' => $data,
        ]);
    }

    /**
     * Displays a single Seller Profile.
     * @param string $id
     * @return mixed
     */
    public function actionProfile($id)
    {
        return $this->render('profile', [
            'model' => Seller::findOne($id),
            'offerModel' => new Offer(),
        ]);
    }
}
