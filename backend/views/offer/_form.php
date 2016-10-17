<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Offer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="offer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'offerId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'itemId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'policyId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shippingId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pricePerUnit')->textInput() ?>

    <?= $form->field($model, 'discountPerUnit')->textInput() ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'imageHashes')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'keywords')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'condition')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
