<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Item */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-form">

    <?php $form = ActiveForm::begin(['action' => ['/item/create'] , 'options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= \machour\yii2\adminlte\widgets\Box::begin([
      'type' => 'box-success',
      'color' => '',
      'noPadding' => false,
      'header' => [
        'title' => 'Criar Item',
        'class' => 'with-border',
        'tools' => '{collapse}',
      ],
    ]); ?>
        <?php $dataCategory=ArrayHelper::map(\common\models\Category::find()->where(['<>', 'categoryId', '0'])->asArray()->all(), 'categoryId', 'name'); ?>

        <?= $form->field($model, 'categoryId')->dropDownList(
            $dataCategory,
            ['prompt'=>' - Escolha uma Categoria - ']
        ) ?>
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>

        <?= \machour\yii2\adminlte\widgets\Box::footer(); ?>
            <?= Html::submitButton('Criar', ['class' => 'btn btn-success']) ?>
            <?= Html::resetButton('Limpar', ['class' => 'btn btn-danger pull-right']) ?>
    <?= \machour\yii2\adminlte\widgets\Box::end(); ?>

    <?php ActiveForm::end(); ?>

</div>
