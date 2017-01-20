<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

//$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
$resetLink = "http://ondetem-gn.com.br/site/reset-password?key=" . $data['key'];
?>
<div class="password-reset">
    <p>Olá <?= Html::encode($data['username']) ?>,</p>

    <p>Clique no link abaixo e você receberá uma nova senha:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>

    <p>Se, por acaso, você não pediu uma nova senha, desconsidere esse email!</p>
</div>
