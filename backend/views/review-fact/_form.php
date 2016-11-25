<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ReviewFact */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="review-fact-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'reviewFactId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'actionId')->textInput() ?>

    <?= $form->field($model, 'offerId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'buyerId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sellerId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'reviewId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'grades')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rating')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
