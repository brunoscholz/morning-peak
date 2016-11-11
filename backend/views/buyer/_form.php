<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Buyer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="buyer-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'imageCover')->fileInput() ?>

    <?= $form->field($model, 'imageThumb')->fileInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dob')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'about')->textInput(['maxlength' => true]) ?>

    <?php
        $dataGender = array('mas' => 'Masculino', 'fem' => 'Feminino', 'oth' => 'Outro');
        //ArrayHelper::map(\backend\models\Category::find()->where(['<>', 'categoryId', '0'])->asArray()->all(), 'categoryId', 'name');
    ?>

    <?= $form->field($model, 'gender')->dropDownList(
        $dataGender,
        ['prompt'=>' - Selecione seu gênero - ']
    ) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'website')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
