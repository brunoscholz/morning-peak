<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */

$myImages = Url::to('@web/img/');
$thumb = $myImages . '/generic-avatar.png';
$cover = $myImages . '/generic-cover.jpg';

?>

<div class="profile-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $model->errorSummary($form); ?>

    <div class="row">
        <div class="col-md-4">
            <?= \machour\yii2\adminlte\widgets\Box::begin([
              'type' => 'box-success',
              'color' => '',
              'noPadding' => false,
              'header' => [
                'title' => 'Alterar Capa',
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
                    ])->label(false); ?>
                </div>
            <?= \machour\yii2\adminlte\widgets\Box::footer(); ?>
                <?= Html::submitButton('Salvar', ['class' => 'btn btn-primary pull-right']) ?>
            <?= \machour\yii2\adminlte\widgets\Box::end(); ?>

            <?= \machour\yii2\adminlte\widgets\Box::begin([
              'type' => 'box-success',
              'color' => '',
              'noPadding' => false,
              'header' => [
                'title' => 'Alterar Avatar',
                'class' => 'with-border',
                'tools' => '{collapse}',
              ],
            ]); ?>
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
                    ])->label(false); ?>
                </div>
            <?= \machour\yii2\adminlte\widgets\Box::footer(); ?>
                <?= Html::submitButton('Salvar', ['class' => 'btn btn-primary pull-right']) ?>
            <?= \machour\yii2\adminlte\widgets\Box::end(); ?>

        </div>

        <div class="col-md-8">
            <?= \machour\yii2\adminlte\widgets\Box::begin([
              'type' => 'box-primary',
              'color' => '',
              'noPadding' => false,
              'header' => [
                'title' => 'Alterar Perfil',
                'class' => 'with-border',
                'tools' => '{collapse}',
              ],
            ]); ?>
                <?= $form->field($model->user, 'email')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model->buyer, 'name')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model->buyer, 'dob')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model->buyer, 'about')->textInput(['maxlength' => true]) ?>
                <?php
                    //ArrayHelper::map(\backend\models\Category::find()->where(['<>', 'categoryId', '0'])->asArray()->all(), 'categoryId', 'name');
                    $dataGender = array('mas' => 'Masculino', 'fem' => 'Feminino', 'oth' => 'Outro');
                ?>
                <?= $form->field($model->buyer, 'gender')->dropDownList(
                    $dataGender,
                    ['prompt'=>' - Selecione seu gênero - ']
                ) ?>
                <?= $form->field($model->buyer, 'website')->textInput(['maxlength' => true]) ?>
            <?= \machour\yii2\adminlte\widgets\Box::footer(); ?>
                <?= Html::resetButton('Limpar', ['class' => 'btn btn-default']) ?>
                <?= Html::submitButton('Salvar', ['class' => 'btn btn-primary pull-right']) ?>
            <?= \machour\yii2\adminlte\widgets\Box::end(); ?>

        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
//The AJAX request for the Add Another button. It updates the #div-address-form div.
/*$script = <<< JS
JS;
$position = \yii\web\View::POS_READY;
$this->registerJs($script, $position);*/