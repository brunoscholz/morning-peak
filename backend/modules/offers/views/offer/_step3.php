<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

?>

<div class="row">
	<div class="col-md-12" style="text-align: center; margin-bottom: 20px;">
		<h2>Detalhes da Oferta</h2>
	</div>
</div>

<div class="row" style="padding: 0 15px;">
    <div class="col-md-12">
	    <?= $form->field($model->offer, 'pricePerUnit')->textInput() ?>

	    <?= $form->field($model->offer, 'discountPerUnit')->textInput() ?>

	    <?= $form->field($model->offer, 'description')->textInput(['maxlength' => true]) ?>

	    <?php // $form->field($model->offer, 'keywords')->textarea(['rows' => 3]) ?>

	    <!-- $form->field($model, 'itemCondition')->textInput(['maxlength' => true]) -->
	    <?php $dataConditions = ['NEW'=>'Novo', 'USD'=>'Usado (Menos de 1 ano)', 'US1'=>'Usado (Mais de 1 Ano)', 'REM'=>'Remanufaturado', 'DMG'=>'Danificado']; ?>
	    <?= $form->field($model->offer, 'itemCondition')->dropDownList(
	        $dataConditions
	    ) ?>
    </div>

</div>