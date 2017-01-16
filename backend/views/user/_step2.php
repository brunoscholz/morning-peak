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

$thumb = Utils::safePicture($model->picture, 'thumbnail');
$cover = Utils::safePicture($model->picture, 'cover');

?>

<div class="row">
	<div class="col-md-12" style="text-align: center; margin-bottom: 20px;">
		<h2>Fotos do Perfil</h2>
	</div>
</div>
<div class="row" style="padding: 0 15px;">
	<div class="col-md-4">
		<?= \machour\yii2\adminlte\widgets\Box::begin([
	        'type' => 'box-primary',
	        'color' => '',
	        'noPadding' => false,
	        'header' => [
	          'title' => 'Exemplo',
	          'class' => 'with-border',
	          'tools' => '',
	        ],
	        'body' => [
	          'class' => 'box-profile',
	          'bg-image' => $cover,
	        ],
	    ]); ?>
	        <?= Html::img($thumb, ['class' => 'profile-user-img img-responsive img-circle', 'alt' => 'User Image']) ?>
	        <h3 class="profile-username text-center"><?= $model->seller->name ?></h3>
	        <p class="text-muted text-center"><?= $model->seller->email ?></p>
	        <!-- Html::a('Seguir', ['create'], ['class' => 'btn btn-primary btn-block']) -->
	    <?= \machour\yii2\adminlte\widgets\Box::footer(); ?>
	        <div class="row">
	          <div class="col-sm-4 border-right">
	            <div class="description-block">
	              <h5 class="description-header">3,200</h5>
	              <span class="description-text">Views</span>
	            </div>
	            <!-- /.description-block -->
	          </div>
	          <!-- /.col -->
	          <div class="col-sm-4 border-right">
	            <div class="description-block">
	              <h5 class="description-header">13,000</h5>
	              <span class="description-text">Seguidores</span>
	            </div>
	            <!-- /.description-block -->
	          </div>
	          <!-- /.col -->
	          <div class="col-sm-4">
	            <div class="description-block">
	              <h5 class="description-header">35</h5>
	              <span class="description-text">OFERTAS</span>
	            </div>
	            <!-- /.description-block -->
	          </div>
	          <!-- /.col -->
	        </div>
	        <ul class="nav nav-stacked">
	          <li><a href="#"><b>Seguindo</b> <span class="pull-right badge bg-aqua">543</span></a></li>
	          <li><a href="#"><b>Listas</b> <span class="pull-right badge bg-yellow">12</span></a></li>
	        </ul>
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
        <?= \machour\yii2\adminlte\widgets\Box::end(); ?>
    </div>
    <div class="col-md-4">
    	<?= \machour\yii2\adminlte\widgets\Box::begin([
          'type' => 'box-primary',
          'color' => '',
          'noPadding' => false,
          'header' => [
            'title' => 'Avatar',
            'class' => 'with-border',
            'tools' => '',
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
            ])->label(false) ?>
        </div>
        <?= \machour\yii2\adminlte\widgets\Box::end(); ?>
    </div>
</div>