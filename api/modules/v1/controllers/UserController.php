<?php

namespace api\modules\v1\controllers;

use yii\db\Query;
use api\modules\v1\models\Buyer;
use api\modules\v1\models\Seller;
use api\modules\v1\models\User;

/**
 * UserController API (extends \yii\rest\ActiveController)
 * 
 * @return [status,data,count,[error]]
 * @author Bruno Scholz <brunoscholz@yahoo.de>
 */
class UserController extends \yii\rest\ActiveController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
