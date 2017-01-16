<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\ArrayHelper;
use backend\components\Utils;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */

$myImages = Url::to('@web/img/');

$thumb = Utils::safePicture($model->user->buyer->picture, 'thumbnail');
$cover = Utils::safePicture($model->user->buyer->picture, 'cover');

if($model->user->status == "PEN" && ($model->user->password == '' || $model->user->salt == '')):
?>

<div class="row">
	<div class="col-md-12" style="text-align: center; margin-bottom: 20px;">
		<h2>Perfil Usuário</h2>
	</div>
</div>

<div class="row" style="padding: 0 15px;">
    <div class="col-md-4">
        <?= \machour\yii2\adminlte\widgets\Box::begin([
          'type' => 'box-primary',
          'color' => '',
          'noPadding' => false,
          'header' => [
            'title' => 'Perfil Usuário',
            'class' => 'with-border',
            'tools' => '{collapse}',
          ],
        ]); ?>
            <?= $form->field($model->user, 'email')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model->user->buyer, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model->user->buyer, 'dob')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model->user->buyer, 'about')->textInput(['maxlength' => true]) ?>
            <?php
                //ArrayHelper::map(\backend\models\Category::find()->where(['<>', 'categoryId', '0'])->asArray()->all(), 'categoryId', 'name');
                $dataGender = array('mas' => 'Masculino', 'fem' => 'Feminino', 'oth' => 'Outro');
            ?>
            <?= $form->field($model->user->buyer, 'gender')->dropDownList(
                $dataGender,
                ['prompt'=>' - Selecione seu gênero - ']
            ) ?>

        <?= \machour\yii2\adminlte\widgets\Box::end(); ?>

    </div>

    <div class="col-md-4">
        <?= \machour\yii2\adminlte\widgets\Box::begin([
          'type' => 'box-primary',
          'color' => '',
          'noPadding' => false,
          'header' => [
            'title' => 'Criar Senha',
            'class' => 'with-border',
            'tools' => '{collapse}',
          ],
        ]); ?>
            <?= $form->field($model, 'newPassword')->passwordInput()->hint('A senha deve conter pelo menos 1 número')->label('Nova Senha') ?>
            <?= $form->field($model, 'confirmPassword')->passwordInput()->hint('As senhas devem ser iguais')->label('Confirmar Senha') ?>

        <?= \machour\yii2\adminlte\widgets\Box::end(); ?>

    </div>
    <div class="col-md-4">
    	<?= \machour\yii2\adminlte\widgets\Box::begin([
          'type' => 'box-primary',
          'color' => '',
          'noPadding' => false,
          'header' => [
            'title' => 'Foto da Capa',
            'class' => 'with-border',
            'tools' => '',
          ],
        ]); ?>
        <div class="cover-image kv-avatar center-block" style="width:100%">
            <?= $form->field($model->user->buyer->picture, 'imageCover')->widget(FileInput::classname(), [
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
                'options' => ['accept' => 'image/*', 'name' => 'BuyerPicture[imageCover]', 'id' => 'buyer-picture-imagecover'],
            ])->label(false) ?>
        </div>
        <?= \machour\yii2\adminlte\widgets\Box::end(); ?>

        <?= \machour\yii2\adminlte\widgets\Box::begin([
          'type' => 'box-primary',
          'color' => '',
          'noPadding' => false,
          'header' => [
            'title' => 'Logo / Avatar',
            'class' => 'with-border',
            'tools' => '',
          ],
        ]); ?>
        <div class="kv-avatar center-block" style="width:280px;">
            <?= $form->field($model->user->buyer->picture, 'imageThumb')->widget(FileInput::classname(), [
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
                'options' => ['accept' => 'image/*', 'name' => 'BuyerPicture[imageThumb]', 'id' => 'buyer-picture-imagethumb'],
            ])->label(false) ?>
        </div>
        <?= \machour\yii2\adminlte\widgets\Box::end(); ?>
    </div>
</div>

<?php endif; ?>