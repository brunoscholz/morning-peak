<?php

namespace backend\models;

class UserIdentity extends \yii\web\User
{
    public function getUsername()
    {
        return \Yii::$app->user->identity->username;
    }

    public function getName()
    {
        return \Yii::$app->user->identity->name;
    }
}

?>