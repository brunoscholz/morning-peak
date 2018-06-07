<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\jui\AutoComplete;
use yii\web\JsExpression;

use common\models\Item;
use backend\models\ItemSearch;


?>

<div class="row">
	<div class="col-md-12" style="text-align: center; margin-bottom: 20px;">
		<h2>Item</h2>
	</div>
</div>

<div class="row" style="padding: 0 15px;">
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