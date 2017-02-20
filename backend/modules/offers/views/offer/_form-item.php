<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Item */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-form" style="display: none;">

    <?php $dataCategory=ArrayHelper::map(\common\models\Category::find()->where(['<>', 'categoryId', '0'])->asArray()->all(), 'categoryId', 'name'); ?>

    <div class="form-group field-item-categoryid required">
        <label class="control-label" for="item-category">Categoria</label>
        <?= Html::dropDownList('Item[categoryId]', [], $dataCategory, ['class' => 'form-control', 'prompt'=>' - Escolha uma Categoria - ']) ?>
        <div class="help-block"></div>
    </div>

    <div class="form-group field-item-name required">
        <label class="control-label" for="item-name">Nome</label>
        <?= Html::textInput('Item[title]', '', ['class' => 'form-control', 'maxlength' => true]) ?>
        <div class="help-block"></div>
    </div>

    <div class="form-group field-item-description required">
        <label class="control-label" for="item-description">Descrição geral do item</label>
        <?= Html::textArea('Item[description]', '', ['class' => 'form-control']) ?>
        <div class="help-block"></div>
    </div>

    <!-- <div class="form-group field-item-keywords required">
        <label class="control-label" for="item-keywords">Tags</label>
        Html::textInput('item-keywords', '', ['class' => 'form-control', 'maxlength' => true])
        <div class="help-block"></div>
    </div> -->

    <!-- <div class="form-group field-item-imageFiles required">
        <label class="control-label" for="item-imageFiles[]">Descrição</label>
        Html::fileInput('imageFiles[]', '', ['multiple' => true, 'accept' => 'image/*'])
        <div class="help-block"></div>
    </div> -->

    <div class="form-group">
        <?= Html::a('Remover Item', FALSE, ['class'=>'unload-item-form btn btn-primary']) ?>
    </div>

</div>
