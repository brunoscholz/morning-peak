<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \backend\models\LoginForm */

$this->title = 'Entrar';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];

?>

<?php if(!isset($model) || is_null($model) || Yii::$app->session->hasFlash('success')): ?>

<?php else: ?>
<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>OndeTem?</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Escolha uma nova senha e confirme:</p>

        <?php $form = ActiveForm::begin(['id' => 'reset-password-form', 'enableClientValidation' => false]); ?>

        <?= $form
            ->field($model, 'password', $fieldOptions2)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password'), 'autofocus' => true]) ?>

        <?= $form
            ->field($model, 'confirmPassword', $fieldOptions2)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('confirmPassword')]) ?>

        <div class="row">
            <div class="col-xs-8">
                
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <?= Html::submitButton('Salvar', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'change-button']) ?>
            </div>
            <!-- /.col -->
        </div>

        <?php ActiveForm::end(); ?>

    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
<?php endif; ?>