<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php //$dataCategory=ArrayHelper::map(\common\models\Category::find()->asArray()->all(), 'categoryId', 'name'); ?>

    <div class="row">
        <div class="col-md-4">
            <?= \machour\yii2\adminlte\widgets\Box::begin([
              'type' => 'box-primary',
              'color' => '',
              'noPadding' => false,
              'header' => [
                'title' => '',
                'class' => 'with-border',
                'tools' => '{collapse}',
              ],
            ]); ?>
                <!-- $form->field($model, 'parentId')->dropDownList(
                    $dataCategory,
                    []
                ) -->
                <?= $form->field($model, 'parentId', ['options' => ['value'=> '0'] ])->hiddenInput()->label(false) ?>
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'icon')->textInput(['maxlength' => true]) ?>
            <?= \machour\yii2\adminlte\widgets\Box::footer(); ?>
                <?= Html::resetButton('Limpar', ['class' => 'btn btn-default']) ?>
                <?= Html::submitButton($model->isNewRecord ? 'Criar' : 'Salvar', ['class' => ($model->isNewRecord ? 'btn btn-success' : 'btn btn-primary') . ' pull-right']) ?>
            <?= \machour\yii2\adminlte\widgets\Box::end(); ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
