<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\components\Utils;

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/bower') . '/adminlte/dist';

$this->title = $model['name'];
//$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model['name']];

?>

<div class="seller-view">
  <div class="row">
    <div class="col-md-3">

      <!-- Profile Image -->
      <?= \machour\yii2\adminlte\widgets\Box::begin([
        'type' => 'box-widget',
        'color' => '',
        'noPadding' => false,
        'header' => [
          'title' => $this->title,
          'class' => 'with-border',
          'tools' => '',
        ],
        'body' => [
          'class' => 'box-profile',
          'bg-image' => Utils::safePicture($model->picture, 'cover'),
        ],
      ]); ?>
        <?= Html::img(Utils::safePicture($model->picture, 'thumbnail'), ['class' => 'profile-user-img img-responsive img-circle', 'alt' => 'User Image']) ?>
        <h3 class="profile-username text-center"><?= $model->name ?></h3>
        <p class="text-muted text-center"><?= $model->email ?></p>
        <!-- Html::a('Seguir', ['create'], ['class' => 'btn btn-primary btn-block']) -->
      <?= \machour\yii2\adminlte\widgets\Box::footer(); ?>
        <div class="row">
          <!-- /.col -->
          <div class="col-sm-6 border-right">
            <div class="description-block">
              <h5 class="description-header"><?= count($model->followers) ?></h5>
              <span class="description-text">Seguidores</span>
            </div>
            <!-- /.description-block -->
          </div>
          <!-- /.col -->
          <div class="col-sm-6">
            <div class="description-block">
              <h5 class="description-header"><?= count($model->offers) ?></h5>
              <span class="description-text">OFERTAS</span>
            </div>
            <!-- /.description-block -->
          </div>
          <!-- /.col -->
        </div>
        <ul class="nav nav-stacked">
          <!-- <li><a href="#"><b>Seguindo</b> <span class="pull-right badge bg-aqua">543</span></a></li>
          <li><a href="#"><b>Listas</b> <span class="pull-right badge bg-yellow">12</span></a></li> -->
        </ul>
      <?= \machour\yii2\adminlte\widgets\Box::end(); ?>

      <!-- About Me Box -->
      <?= \machour\yii2\adminlte\widgets\Box::begin([
        'type' => 'box-primary',
        'color' => '',
        'noPadding' => false,
        'header' => [
          'title' => 'Sobre a '. $model->name,
          'class' => 'with-border',
          'tools' => '',
        ],
      ]); ?>
        <strong><i class="fa fa-book margin-r-5"></i>  Bio</strong>
        <p class="text-muted">
          <?= $model->about; ?>
        </p>
        <hr>
        <strong><i class="fa fa-map-marker margin-r-5"></i> Endereço</strong>
        <p class="text-muted"><?= $model->billingAddress->getFullAddress() ?></p>
      <?= \machour\yii2\adminlte\widgets\Box::end(); ?>
      <!-- 
      <hr>
      <strong><i class="fa fa-pencil margin-r-5"></i> Categorias</strong>
      <p>
        <span class="label label-danger">UI Design</span>
        <span class="label label-success">Coding</span>
        <span class="label label-info">Javascript</span>
        <span class="label label-warning">PHP</span>
        <span class="label label-primary">Node.js</span>
      </p>
      <hr>
      <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
      -->
    </div>

    <div class="col-md-9">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#newoffer" data-toggle="tab">Nova Oferta</a></li>
          <!-- <li><a href="#activity" data-toggle="tab">Atividade</a></li>
          <li><a href="#timeline" data-toggle="tab">Timeline</a></li> -->
          <li><a href="#offers" data-toggle="tab">Catálogo</a></li>
          <!-- <li><a href="#settings" data-toggle="tab">Configurações</a></li> -->
        </ul>
        <div class="tab-content">

          <div class="active tab-pane" id="newoffer">
            <?php
              $offerForm = new \backend\models\form\OfferForm();
              $offerForm->offer = new \common\models\Offer();
              echo $this->render('/offer/_createform', ['model' => $offerForm, 'seller' => $model]);
            ?>
          </div><!-- /.tab-pane -->

          <div class="tab-pane" id="offers">
            <?= $this->render('/offer/list', ['model' => $model->offers]) ?>
          </div>

          <div class="tab-pane" id="settings">

          </div>
          <!-- /.tab-pane -->

        </div><!-- /.tab-content -->
      </div><!-- /.nav-tabs-custom -->
    </div><!-- /.col -->
  </div><!-- /.row -->

</div>

