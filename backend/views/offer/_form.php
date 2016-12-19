<?php

use common\models\Item;
use backend\models\ItemSearch;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\ArrayHelper;
use yii\jui\AutoComplete;
use yii\web\JsExpression;


/* @var $this yii\web\View */
/* @var $model app\models\Offer */
/* @var $form yii\widgets\ActiveForm */
$myImages = Url::to('@web/img/');
$cover = $myImages . '/generic-cover.jpg';
?>

<div class="offer-form">
    <?php $form = ActiveForm::begin(['action' => ['offer/update', 'id' => $model->offerId], 'options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
        <div class="col-md-4">

            <?= \machour\yii2\adminlte\widgets\Box::begin([
              'type' => 'box-success',
              'color' => '',
              'noPadding' => false,
              'header' => [
                'title' => 'Foto',
                'class' => 'with-border',
                'tools' => '{collapse}',
              ],
            ]); ?>
                <div class="cover-image kv-avatar center-block" style="width:100%">
                    <?= $form->field($model->picture, 'imageCover')->widget(FileInput::classname(), [
                        'pluginOptions' => [
                            'resizeImages' => true,
                            'overwriteInitial' => true,
                            'maxFileSize' => 1500,
                            'showClose' => false,
                            'showCaption' => false,
                            'showBrowse' => false,
                            'browseOnZoneClick' => true,
                            'browseLabel' => '',
                            'removeLabel' => '',
                            'removeIcon' => '<i class="glyphicon glyphicon-remove"></i>',
                            'removeTitle' => 'Cancelar',
                            'elErrorContainer' => '#kv-avatar-errors-2',
                            'msgErrorClass' => 'alert alert-block alert-danger',
                            'defaultPreviewContent' => "<img src='$cover' alt='Avatar' style='width:100%'><h6 class='text-muted'>Click to select</h6>",
                            //'layoutTemplates' => "{main2: '{preview} ' +  btnCust + ' {remove} {browse}'}",
                            'layoutTemplates' => [
                                'main2' => '{preview}<div class="kv-upload-progress hide"></div>{remove}{browse}',
                            ],
                            'allowedFileExtensions' => ["jpg", "png", "gif"],
                            'maxImageWidth' => 1024,
                            'maxImageHeight' => 680,
                        ],
                        'options' => ['accept' => 'image/*'],
                    ])->label(false) ?>
                </div>
            <?= \machour\yii2\adminlte\widgets\Box::end(); ?>

        </div>

        <div class="col-md-8">
            <?= \machour\yii2\adminlte\widgets\Box::begin([
              'type' => 'box-primary',
              'color' => '',
              'noPadding' => false,
              'header' => [
                'title' => 'Cadastrar Oferta',
                'class' => 'with-border',
                'tools' => '',
              ],
            ]); ?>

            <?php //$dataPolicies=ArrayHelper::map(\common\models\Policy::find()->asArray()->all(), 'policyId', 'description'); ?>
            <!--
            $form->field($model, 'policyId')->dropDownList(
                $dataPolicies
                //['prompt'=>' - Escolha um Termo de Uso - ']
            )
            -->

            <!-- $form->field($model, 'shippingId')->textInput(['maxlength' => true]) -->

            <?= $form->field($model, 'pricePerUnit')->textInput() ?>

            <?= $form->field($model, 'discountPerUnit')->textInput() ?>

            <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

            <?php // $form->field($model->offer, 'keywords')->textarea(['rows' => 3]) ?>

            <!-- $form->field($model, 'itemCondition')->textInput(['maxlength' => true]) -->
            <?php $dataConditions = ['NEW'=>'Novo', 'USD'=>'Usado (Menos de 1 ano)', 'US1'=>'Usado (Mais de 1 Ano)', 'REM'=>'Remanufaturado', 'DMG'=>'Danificado']; ?>
            <?= $form->field($model, 'itemCondition')->dropDownList(
                $dataConditions
            ) ?>

            <?= \machour\yii2\adminlte\widgets\Box::footer(); ?>
                <?= Html::submitButton('Salvar', ['class' => 'btn btn-primary']) ?>
                <?= Html::resetButton('Limpar', ['class' => 'btn btn-danger pull-right']) ?>
            <?= \machour\yii2\adminlte\widgets\Box::end(); ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
