<?php

namespace api\modules\v1\controllers;

class AuthController extends \yii\rest\ActiveController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
