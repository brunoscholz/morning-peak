<?php

namespace api\modules\v1\controllers;

use yii\db\Query;
use common\models\Buyer;
use common\models\Seller;
use common\models\User;

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
