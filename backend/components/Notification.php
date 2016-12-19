<?php

namespace backend\components;

use Yii;
use common\models\Offer;
use common\models\FollowFact;
use machour\yii2\notifications\models\Notification as BaseNotification;

class Notification extends BaseNotification
{

    /**
     * A new follower notification
     */
    const KEY_NEW_FOLLOWER = 'new_follower';
    /**
     * An offer has been traded by coins
     */
    const KEY_OFFER_TRADED = 'offer_traded';
    /**
     * User made a category suggestion !
     */
    const CATEGORY_SUGGESTED = 'category_suggested';

    /**
     * @var array Holds all usable notifications
     */
    public static $keys = [
        self::KEY_NEW_FOLLOWER,
        self::KEY_OFFER_TRADED,
        self::CATEGORY_SUGGESTED,
    ];

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        switch ($this->key) {
            case self::KEY_OFFER_TRADED:
                return '<i class="fa fa-shopping-cart text-green"></i> Uma oferta foi trocada!'; //Yii::t('app', 'Meeting reminder');

            case self::KEY_NEW_FOLLOWER:
                return '<i class="fa fa-users text-red"></i> Você tem um novo seguidor'; //Yii::t('app', 'You got a new message');

            case self::CATEGORY_SUGGESTED:
                return '<i class="fa fa-th text-red"></i> Nova categoria sugerida';
        }
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        switch ($this->key) {
            case self::KEY_OFFER_TRADED:
                $offer = Offer::findOne($this->keyId);
                return Yii::t('app', 'Alguém trocou {item}', [
                    'item' => $offer->item->title
                ]);

            case self::KEY_NEW_FOLLOWER:
                $flw = FollowFact::findOne($this->keyId);
                /*Yii::t('app', '{customer} sent you a message', [
                    'customer' => $meeting->customer->name
                ]);*/
                return $flw->user->buyer->name . ' começou a seguir você..';

            case self::CATEGORY_SUGGESTED:
                //$usr = \common\models\User::findOne($this->userId);
                return 'Uma nova categoria foi sugerida.';
        }
    }

    /**
     * @inheritdoc
     */
    public function getRoute()
    {
        switch ($this->key) {
            case self::KEY_OFFER_TRADED:
                return ['/offer/view', 'id' => $this->keyId];

            case self::KEY_NEW_FOLLOWER:
                return ['/buyer/view', 'id' => $this->keyId];

            case self::CATEGORY_SUGGESTED:
                return ['/category/view', 'id' => $this->keyId];
        };
    }

    public static function notifyGroup($key, $user, $keyId = null, $type = self::TYPE_DEFAULT)
    {
        $class = self::className();
        return NotificationsModule::notifyGroup(new $class(), $key, $users, $keyId, $type);
    }
}