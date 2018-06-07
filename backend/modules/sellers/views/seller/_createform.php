<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */

$myImages = Url::to('@web/img/');
$thumb = $myImages . '/generic-avatar.png';
$cover = $myImages . '/generic-cover.jpg';
?>

<div class="profile-form">
  <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

  <div class="col-md-12">
    <?= \machour\yii2\adminlte\widgets\Box::begin([
      'type' => 'box-primary',
      'color' => '',
      'noPadding' => false,
      'header' => [
        'title' => 'Nova Empresa',
        'class' => 'with-border',
        'tools' => '',
      ],
    ]); ?>

      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#profile" data-toggle="tab">Perfil</a></li>
          <li><a href="#photos" data-toggle="tab">Fotos</a></li>
        </ul>
        <div class="tab-content">
          <div class="active tab-pane" id="profile">
            <div class="row">
              <div class="col-md-6">
                <?php
                  $model->seller->userId = \Yii::$app->user->identity->userId;
                  $users=ArrayHelper::map(\backend\models\User::find()->asArray()->all(), 'userId', 'email');
                ?>

                <?= $form->field($model->seller, 'userId')->dropDownList($users, ['encode'=> false, 'prompt'=>' - Selecione um Usuário - '])->label('Usuário (Dono)') ?>
                <?= $form->field($model->seller, 'name')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model->seller, 'about')->textArea(['maxlength' => true]) ?>
                <?= $form->field($model->seller, 'website')->textInput(['maxlength' => true]) ?>

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
                    'mask' => '(99) 9999-9999[9]',
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
          </div><!-- /.tab-pane -->
          <div class="tab-pane" id="photos">
            <div class="row">
              <div class="col-md-4">
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
              </div>
              <div class="col-md-4">
                <div class="kv-avatar center-block" style="width:280px;">
                  <?= $form->field($model->picture, 'imageThumb')->widget(FileInput::classname(), [
                    'pluginOptions' => [
                      'resizeImages' => true,
                      //'initialPreview' => "<img src='$thumb' class='file-preview-image' alt='Avatar' title='Avatar'>",
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
                      'defaultPreviewContent' => "<img src='$thumb' alt='Avatar' style='width:160px'><h6 class='text-muted'>Click to select</h6>",
                      //'layoutTemplates' => "{main2: '{preview} ' +  btnCust + ' {remove} {browse}'}",
                      'layoutTemplates' => [
                          'main2' => '{preview}<div class="kv-upload-progress hide"></div>{remove}{browse}',
                      ],
                      'allowedFileExtensions' => ["jpg", "png", "gif"],
                      'maxImageWidth' => 400,
                      'maxImageHeight' => 400,
                    ],
                    'options' => ['accept' => 'image/*'],
                  ])->label(false) ?>
                </div>
              </div>
            </div>
          </div><!-- /.tab-pane -->
        </div><!-- /.tab-content -->
      </div><!-- /.nav-tabs-custom -->

    <?= \machour\yii2\adminlte\widgets\Box::footer(); ?>
      <?= Html::submitButton('Salvar', ['class' => 'btn btn-primary pull-right']) ?>
      <?= Html::resetButton('Limpar', ['class' => 'btn btn-danger pull-right']) ?>
    <?= \machour\yii2\adminlte\widgets\Box::end(); ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>
