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
    <?php $form = ActiveForm::begin(['action' => ['offer/create'], 'options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= Html::activeHiddenInput($model, 'sellerId', ['value' => $seller->sellerId]) ?>
    <div class="row">
        <div class="col-md-4">
            <?= \machour\yii2\adminlte\widgets\Box::begin([
              'type' => 'box-danger',
              'color' => '',
              'noPadding' => false,
              'header' => [
                'title' => 'Item',
                'class' => 'with-border',
                'tools' => '',
              ],
            ]); ?>
                <?php
                    //$searchModel = new ItemSearch();
                    $data = Item::find()->select(['title as value', 'description as label','itemId as id'])->asArray()->all();
                ?>
                <div class="form-group field-offer-itemid required">
                    <label class="control-label" for="offer-item">Buscar um Item</label>
                    <?php
                        echo AutoComplete::widget([
                            'id' => 'offer-item',
                            'name' => 'Offer[item]',
                            'clientOptions' => [
                                'source' => $data,
                                'autoFill'=>true,
                                'minLength'=>'3',
                                'select' => new JsExpression("function( event, ui ) {
                                    $('.item-view .item-result').html(
                                        '<h3>' + ui.item.value + '</h3>' + '<p>' + ui.item.label + '</p>');

                                    $('.item-view').show();
                                    $('.field-offer-itemid').hide();
                                    $('#offer-itemid').val(ui.item.id);
                                }")
                            ],
                            'options' => [
                                'class' => 'form-control',
                            ],
                         ]);
                    ?>
                    <?= Html::activeHiddenInput($model->offer, 'itemId') ?>
                    <div class="help-block"></div>
                    <div class="form-group">
                        ou <?= Html::a('Adicionar Item', FALSE, ['class'=>'load-item-form btn btn-primary']) ?>
                    </div>
                </div>

                <?= $this->render('_form-item', [
                    'model' => new Item(),
                ]) ?>

                <?= $this->render('_view-item', [
                    'model' => Item::findOne($model->offer->itemId),
                ]) ?>
            <?= \machour\yii2\adminlte\widgets\Box::end(); ?>

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

            <?= $form->field($model->offer, 'pricePerUnit')->textInput() ?>

            <?= $form->field($model->offer, 'discountPerUnit')->textInput() ?>

            <?= $form->field($model->offer, 'description')->textInput(['maxlength' => true]) ?>

            <?php // $form->field($model->offer, 'keywords')->textarea(['rows' => 3]) ?>

            <!-- $form->field($model, 'itemCondition')->textInput(['maxlength' => true]) -->
            <?php $dataConditions = ['NEW'=>'Novo', 'USD'=>'Usado (Menos de 1 ano)', 'US1'=>'Usado (Mais de 1 Ano)', 'REM'=>'Remanufaturado', 'DMG'=>'Danificado']; ?>
            <?= $form->field($model->offer, 'itemCondition')->dropDownList(
                $dataConditions
            ) ?>

            <?= \machour\yii2\adminlte\widgets\Box::footer(); ?>
                <?= Html::submitButton('Criar', ['class' => 'btn btn-success']) ?>
                <?= Html::resetButton('Limpar', ['class' => 'btn btn-danger pull-right']) ?>
            <?= \machour\yii2\adminlte\widgets\Box::end(); ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<?php
//The AJAX request for the Add Another button. It updates the #div-address-form div.
$script = <<< JS
$(document).on('click', '.load-item-form', function(){
    $('.item-form').show();
    $('.field-offer-itemid').hide();
});

$(document).on('click', '.unload-item-form', function(){
    $('.item-form').hide();
    $('.field-offer-itemid').show();
});

$(document).on('click', '.unload-item-view', function(){
    $('.item-view').hide();
    $('.field-offer-itemid').show();
    $('#offer-item').value = '';
});

$('#offer-item').autocomplete('instance')._renderItem = function(ul, item) {
    return $("<li>")
        .append( "<div><b>Item:</b> " + item.value + "<br>" + item.label + "</div>" )
        .appendTo( ul );
    };
JS;
$position = \yii\web\View::POS_READY;
$this->registerJs($script, $position);
/*"
    $(document).on('click', '#button-add-another', function(){
        $.ajax({
            url: '" . \Yii::$app->urlManager->createUrl(['address/add-additional-row']) . "',
            type: 'post',
            data: $('#" . $form->id . "').serialize(),
            dataType: 'html',
            success: function(data) {
                $('#div-address-form').html(data);
            },
            error: function() {
                alert('An error has occured while adding a new block.');
            }
        });
    });
");*/
?>