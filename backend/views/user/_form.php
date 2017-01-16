<?php

use yii\helpers\Html;
use backend\components\Utils;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */

$buyer = $model->buyer;
$thumb = Utils::safePicture($buyer->picture, 'thumbnail');
$cover = Utils::safePicture($buyer->picture, 'cover');

?>

<div class="user-form">
    <?php $form = ActiveForm::begin(['action' => ['user/update', 'id' => $model->user->userId], 'options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $model->errorSummary($form); ?>

    <div class="row">
        <div class="col-md-4">
            <?= \machour\yii2\adminlte\widgets\Box::begin([
              'type' => 'box-danger',
              'color' => '',
              'noPadding' => false,
              'header' => [
                'title' => 'Alterar Senha',
                'class' => 'with-border',
                'tools' => '{collapse}',
              ],
            ]); ?>
                <?= $form->field($model, 'checkPassword')->passwordInput()->label('Senha') ?>
                <?= $form->field($model, 'newPassword')->passwordInput()->hint('A senha deve conter pelo menos 1 número')->label('Nova Senha') ?>
                <?= $form->field($model, 'confirmPassword')->passwordInput()->hint('As senhas devem ser iguais')->label('Confirmar Senha') ?>
            <?= \machour\yii2\adminlte\widgets\Box::footer(); ?>
                <?= Html::resetButton('Limpar', ['class' => 'btn btn-default']) ?>
                <?= Html::submitButton('Salvar', ['class' => 'btn btn-primary pull-right']) ?>
            <?= \machour\yii2\adminlte\widgets\Box::end(); ?>
        </div>
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
                <div class="form-group cover-image kv-avatar center-block" style="width:100%">
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
        </div>
        <div class="col-md-4">
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
                <div class="form-group kv-avatar center-block" style="width:280px;">
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
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= \machour\yii2\adminlte\widgets\Box::begin([
              'type' => 'box-primary',
              'color' => '',
              'noPadding' => false,
              'header' => [
                'title' => '',
                'class' => 'with-border',
                'tools' => '{collapse}',
              ],
            ]); ?>
                <?= $form->field($model->user, 'email')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model->buyer, 'name')->textInput(['maxlength' => true]) ?>
                <?php
                    //ArrayHelper::map(\backend\models\Category::find()->where(['<>', 'categoryId', '0'])->asArray()->all(), 'categoryId', 'name');
                    $dataRole = array('administrator' => 'Administrador', 'salesman' => 'Vendedor', 'regular' => 'Comum');
                ?>
                <?= $form->field($model->user, 'role')->dropDownList(
                    $dataRole,
                    ['prompt'=>' - Tipo de usuário - ']
                ) ?>

            <?= \machour\yii2\adminlte\widgets\Box::footer(); ?>
                <?= Html::submitButton('Salvar', ['class' => 'btn btn-primary pull-right']) ?>
            <?= \machour\yii2\adminlte\widgets\Box::end(); ?>

        </div>
        <div class="col-md-6">
            <?= \machour\yii2\adminlte\widgets\Box::begin([
              'type' => 'box-primary',
              'color' => '',
              'noPadding' => false,
              'header' => [
                'title' => '',
                'class' => 'with-border',
                'tools' => '{collapse}',
              ],
            ]); ?>
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
            <?= \machour\yii2\adminlte\widgets\Box::footer(); ?>
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