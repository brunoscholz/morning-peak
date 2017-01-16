<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;


?>

<div class="row">
	<div class="col-md-12" style="text-align: center; margin-bottom: 20px;">
		<h2>Perfil Empresa</h2>
	</div>
</div>

<div class="row" style="padding: 0 15px;">
    <div class="col-md-6">
        <?php
            //$model->seller->userId = \Yii::$app->user->identity->userId;
            // $users=ArrayHelper::map(\backend\models\User::find()->asArray()->all(), 'userId', 'email');
            // echo $form->field($model->seller, 'userId')->dropDownList($users, ['encode'=> false, 'prompt'=>' - Selecione um Usuário - '])->label('Usuário (Dono)');
        ?>

        <?= $form->field($model->seller->activeLicense->licenseType, 'description')->textInput(['maxlength' => true, 'disabled'=>'disabled'])->label('Licença') ?>

        <?= $form->field($model->seller, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model->seller, 'about')->textArea(['maxlength' => true]) ?>
        <?= $form->field($model->seller, 'website')->textInput(['maxlength' => true]) ?>
        
        <div class="form-group center-block">
        <label for="days">Horário de Funcionamento</label><br>
        <?php
            $days = array(
                        "todos os dias"=>"todos os dias",
                        "de segunda a sábado"=>"de segunda a sábado",
                        "de segunda a sexta"=>"de segunda a sexta",
                        "de terça a domingo"=>"de terça a domingo"
                    );

            $hours = array(
                        "24 horas"=>"24 horas",
                        "das 8h as 18h"=>"das 8h as 18h",
                        "das 8h as 20h"=>"das 8h as 20h",
                        "das 8h as 14h"=>"das 8h as 14h",
                        "das 10h as 16h"=>"das 10h as 16h",
                        "das 18h as 0h"=>"das 18h as 0h",
                    );
        ?>
            
        <?= Html::dropDownList('days', [], $days, [
            //'multiple' => 'multiple',
            //'class' => 'multiselect',
        ]) ?>

        <?= Html::dropDownList('hours', [], $hours, [
            //'multiple' => 'multiple',
            //'class' => 'multiselect',
        ]) ?>
        </div>

        <?php
            $dataCategory=ArrayHelper::map(\backend\models\PaymentLookup::find()->asArray()->all(), 'name', 'icon', 'paymentId');
            $list = [];
            foreach ($dataCategory as $key => $value)
            {
                foreach ($value as $k => $v)
                {
                    $tmp = '<img src="data:image/gif;base64,' . $v . '" alt="'.$k.'" title="'.$k.'" width="51" height="32"/>';
                    $list[$key] = $tmp;
                }
            }
        ?>
        
        <?= $form->field($model->seller, 'paymentOptions')->checkboxList($list, ['encode'=> false]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model->seller, 'phone')->widget(\yii\widgets\MaskedInput::className(), [
            'clientOptions' => [
                'removeMaskOnSubmit' => true,
            ],
            'mask' => '(99) 9999-9999[9]',
        ]) ?>
        <?= $form->field($model->seller, 'cellphone')->widget(\yii\widgets\MaskedInput::className(), [
            'clientOptions' => [
                'removeMaskOnSubmit' => true,
            ],
            'mask' => '(99) [9]9999-9999',
        ]) ?>

        <?= $form->field($model->billingAddress, 'address')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model->billingAddress, 'neighborhood')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model->billingAddress, 'city')->textInput(['maxlength' => true]) ?>
        <?php
            $states = array("AC"=>"Acre", "AL"=>"Alagoas", "AM"=>"Amazonas", "AP"=>"Amapá","BA"=>"Bahia","CE"=>"Ceará","DF"=>"Distrito Federal","ES"=>"Espírito Santo","GO"=>"Goiás","MA"=>"Maranhão","MT"=>"Mato Grosso","MS"=>"Mato Grosso do Sul","MG"=>"Minas Gerais","PA"=>"Pará","PB"=>"Paraíba","PR"=>"Paraná","PE"=>"Pernambuco","PI"=>"Piauí","RJ"=>"Rio de Janeiro","RN"=>"Rio Grande do Norte","RO"=>"Rondônia","RS"=>"Rio Grande do Sul","RR"=>"Roraima","SC"=>"Santa Catarina","SE"=>"Sergipe","SP"=>"São Paulo","TO"=>"Tocantins")
        ?>
        <?= $form->field($model->billingAddress, 'state')->dropDownList($states, [
            'options' => [                        
                'PR' => ['selected' => 'selected']
            ]
        ]) ?>
        <?= $form->field($model->billingAddress, 'postCode')->widget(\yii\widgets\MaskedInput::className(), [
            'clientOptions' => [
                'removeMaskOnSubmit' => true,
            ],
            'mask' => '99-999-999',
        ]) ?>
    </div>
</div>