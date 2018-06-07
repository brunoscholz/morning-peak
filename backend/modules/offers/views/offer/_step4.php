<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

use kartik\file\FileInput;

$myImages = Url::to('@web/img/');
$cover = $myImages . '/generic-cover.jpg';
?>

<div class="row">
	<div class="col-md-12" style="text-align: center; margin-bottom: 20px;">
		<h2>Fotos</h2>
	</div>
</div>

<div class="row" style="padding: 0 15px;">
    <div class="col-md-6">
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
</div>