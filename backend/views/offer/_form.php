<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Item;
use yii\jui\AutoComplete;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\models\Offer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="offer-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <!-- $form->field($model, 'itemId')->textInput(['maxlength' => true]) -->
    <?php 
        $data = Item::find()
            ->select(['title as value', 'title as label','itemId as id'])->asArray()->all();
    ?>
    <div class="form-group field-offer-itemid required">
        <label class="control-label" for="offer-item">Buscar um Item</label>
        <?php
            echo AutoComplete::widget([
                'name' => 'Offer[item]',
                'id' => 'offer-item',
                'clientOptions' => [
                    'source' => $data,
                    'autoFill'=>true,
                    'minLength'=>'4',
                    'select' => new JsExpression("function( event, ui ) {
                        $('#offer-item').val(ui.item.id);
                    }")
                ],
                'options' => [
                    'class' => 'form-control',
                ],
             ]);
        ?>
        <?= Html::activeHiddenInput($model, 'itemId')?>
        <div class="help-block"></div>
        <div class="form-group">
            ou <?= Html::a('Adicionar Item', FALSE, ['class'=>'load-item-form btn btn-primary']) ?>
        </div>
    </div>

    <?= $this->render('_form-item', [
        'model' => new \backend\models\Item(),
    ]) ?>

    <!-- $form->field($model, 'policyId')->textInput(['maxlength' => true]) -->
    <?php $dataPolicies=ArrayHelper::map(\backend\models\Policy::find()->asArray()->all(), 'policyId', 'description'); ?>

    <?= $form->field($model, 'policyId')->dropDownList(
        $dataPolicies
        //['prompt'=>' - Escolha um Termo de Uso - ']
    ) ?>

    <!-- $form->field($model, 'shippingId')->textInput(['maxlength' => true]) -->

    <?= $form->field($model, 'pricePerUnit')->textInput() ?>

    <?= $form->field($model, 'discountPerUnit')->textInput() ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'keywords')->textarea(['rows' => 6]) ?>

    <!-- $form->field($model, 'itemCondition')->textInput(['maxlength' => true]) -->
    <?php $dataConditions = ['NEW'=>'Novo', 'USD'=>'Usado (Menos de 1 ano)', 'US1'=>'Usado (Mais de 1 Ano)', 'REM'=>'Remanufaturado', 'DMG'=>'Danificado']; ?>
    <?= $form->field($model, 'itemCondition')->dropDownList(
        $dataConditions,
        ['prompt'=>' - Selecione uma condição - ']
    ) ?>

    <?= $form->field($model, 'imageCover')->fileInput() ?>

    <?= $form->field($model, 'imageThumb')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Criar' : 'Salvar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script type="text/javascript">
    $(function(){
        //load the current page with the conten indicated by 'value' attribute for a given button.
        $(document).on('click', '.load-item-form', function(){
            $('.item-form').show();
        });
    });
</script>

<?php
//The AJAX request for the Add Another button. It updates the #div-address-form div.
$this->registerJs(
    "$(function(){
        $(document).on('click', '.load-item-form', function(){
            $('.item-form').show();
            $('.field-offer-itemid').hide();
        });

        $(document).on('click', '.unload-item-form', function(){
            $('.item-form').hide();
            $('.field-offer-itemid').show();
        });
    });");
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