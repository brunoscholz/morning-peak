<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Item;
use backend\models\ItemSearch;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Offer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="offer-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

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
                                    $('#offer-item').val(ui.item.id);
                                }")
                            ],
                            'options' => [
                                'class' => 'form-control',
                            ],
                         ]);
                    ?>
                    <?= Html::activeHiddenInput($model, 'itemId') ?>
                    <div class="help-block"></div>
                    <div class="form-group">
                        ou <?= Html::a('Adicionar Item', FALSE, ['class'=>'load-item-form btn btn-primary']) ?>
                    </div>
                </div>

                <?= $this->render('_form-item', [
                    'model' => new Item(),
                ]) ?>

                <?= $this->render('_view-item', [
                    'model' => Item::findOne($model->itemId),
                ]) ?>
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

            <?= $form->field($model, 'keywords')->textarea(['rows' => 6]) ?>

            <!-- $form->field($model, 'itemCondition')->textInput(['maxlength' => true]) -->
            <?php $dataConditions = ['NEW'=>'Novo', 'USD'=>'Usado (Menos de 1 ano)', 'US1'=>'Usado (Mais de 1 Ano)', 'REM'=>'Remanufaturado', 'DMG'=>'Danificado']; ?>
            <?= $form->field($model, 'itemCondition')->dropDownList(
                $dataConditions
            ) ?>

            <?= $form->field($model, 'imageCover')->fileInput() ?>

            <?= $form->field($model, 'imageThumb')->fileInput() ?>

            <?= \machour\yii2\adminlte\widgets\Box::footer(); ?>
                <?= Html::resetButton('Limpar', ['class' => 'btn btn-default']) ?>
                <?= Html::submitButton($model->isNewRecord ? 'Criar' : 'Salvar', ['class' => ($model->isNewRecord ? 'btn btn-success' : 'btn btn-primary') . ' pull-right']) ?>
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