<?php

namespace backend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use backend\components\Utils;
use backend\components\Notification;
use common\components\BaseController;


use common\models\Seller;
use backend\models\SellerSearch;
use common\models\Offer;
use backend\models\OfferSearch;

class DashboardController extends BaseController
{
	public function behaviors()
    {
        /*
        return [
            'acl' => [
                'class' => \humhub\components\behaviors\AccessControl::className(),
                'guestAllowedActions' => [
                    'index',
                    'stream'
                ]
            ]
        ];
        */
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login','error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout','index','profile','notify'],
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

        //Utils::setFlash('error', 'my message...');

        //$auth = Yii::$app->authManager;
        //var_dump(Yii::$app->user->can('updateOwnProfile'));

        return $this->render('index');
    }

    public function actionNotify()
    {
        // $message was just created by the logged in user, and sent to $recipient_id
        /*Notification::notify(Notification::KEY_NEW_MESSAGE, $recipient_id, $message->id);

        // You may also use the following static methods to set the notification type:
        Notification::warning(Notification::KEY_NEW_MESSAGE, $recipient_id, $message->id);
        Notification::success(Notification::ORDER_PLACED, $admin_id, $order->id);
        Notification::error(Notification::KEY_NO_DISK_SPACE, '1234acanidqo1');
        */

        Notification::notify(Notification::KEY_OFFER_TRADED, Yii::$app->user->identity->userId, 'TDh7O1NJPqfCgoECYnEau');
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
