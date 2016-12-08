<?php

namespace backend\controllers;

use Yii;
use backend\models\Seller;
use backend\models\Offer;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class DashboardController extends Controller
{
	public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login','error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout','index','profile'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
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
    public function actionProfile()
    {
        $pref = Yii::$app->user->identity->preferredProfile;

        if($pref['type'] == 'seller')
            return $this->render('profile', [
                'seller' => Seller::findOne($pref['id'])
            ]);
        else
            return $this->render('profile', [
                'buyer' => Seller::findOne($pref['id'])
            ]);

    }
}
