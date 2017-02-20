<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\components\Utils;

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/bower') . '/adminlte/dist';

$this->title = $model->buyer['name'];
//$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->buyer['name']];
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
          'bg-image' => Utils::safePicture($model->buyer->picture, 'cover'),
        ],
      ]); ?>
        <?= Html::img(Utils::safePicture($model->buyer->picture, 'thumbnail'), ['class' => 'profile-user-img img-responsive img-circle', 'alt' => 'User Image']) ?>
        <h3 class="profile-username text-center"><?= $model->buyer->name ?></h3>
        <p class="text-muted text-center"><?= $model->buyer->email ?></p>
        <!-- Html::a('Seguir', ['create'], ['class' => 'btn btn-primary btn-block']) -->
      <?= \machour\yii2\adminlte\widgets\Box::footer(); ?>
        <div class="row">
          <!-- /.col -->
          <div class="col-sm-4 border-right">
            <div class="description-block">
              <h5 class="description-header"><?= count($model->buyer->followers) ?></h5>
              <span class="description-text">Seguidores</span>
            </div>
            <!-- /.description-block -->
          </div>
          <!-- /.col -->
          <div class="col-sm-4">
            <div class="description-block">
              <h5 class="description-header"><?= count($model->buyer->following) ?></h5>
              <span class="description-text">Seguindo</span>
            </div>
            <!-- /.description-block -->
          </div>
          <div class="col-sm-4 border-right">
            <div class="description-block">
              <h5 class="description-header"><?= count($model->buyer->favorites) ?></h5>
              <span class="description-text">Favoritos</span>
            </div>
            <!-- /.description-block -->
          </div>
          <!-- /.col -->
        </div>
        <ul class="nav nav-stacked">
          <!-- <li><a href="#"><b>Seguindo</b> <span class="pull-right badge bg-aqua">543</span></a></li> -->
          <!-- <li><a href="#"><b>Favoritos</b> <span class="pull-right badge bg-yellow">12</span></a></li> -->
        </ul>
      <?= \machour\yii2\adminlte\widgets\Box::end(); ?>

      <!-- About Me Box -->
      <?= \machour\yii2\adminlte\widgets\Box::begin([
        'type' => 'box-primary',
        'color' => '',
        'noPadding' => false,
        'header' => [
          'title' => $model->buyer->name,
          'class' => 'with-border',
          'tools' => '',
        ],
      ]); ?>
        <strong><i class="fa fa-book margin-r-5"></i>  Bio</strong>
        <p class="text-muted">
          <?= $model->buyer->about; ?>
        </p>
        <hr>
        <strong><i class="fa fa-map-marker margin-r-5"></i> Saldos</strong>
        <p class="text-muted">COIN: <?= $model->buyer->coinsBalance ?></p>
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
          <!-- <li class="active"><a href="#activity" data-toggle="tab">Atividade</a></li> -->
          <!-- <li><a href="#timeline" data-toggle="tab">Timeline</a></li> -->
          <li><a href="#offers" data-toggle="tab">Favoritos</a></li>
          <li><a href="#settings" data-toggle="tab">Configurações</a></li>
        </ul>
        <div class="tab-content">

          <div class="tab-pane" id="activity">
            <!-- novos reviews -->
            <!-- Post -->
            <div class="post">
              <div class="user-block">
                <img class="img-circle img-bordered-sm" src="<?= $directoryAsset ?>/img/user1-128x128.jpg" alt="user image">
                <span class='username'>
                  <a href="#">Jonathan Burke Jr.</a>
                  <a href='#' class='pull-right btn-box-tool'><i class='fa fa-times'></i></a>
                </span>
                <span class='description'>Avaliou {Produto} - 7:30 PM today</span>
              </div><!-- /.user-block -->
              <p>
                Lorem ipsum represents a long-held tradition for designers,
                typographers and the like. Some people hate it and argue for
                its demise, but others ignore the hate as they create awesome
                tools to help create filler text for everyone from bacon lovers
                to Charlie Sheen fans.
              </p>
              <ul class="list-inline">
                <li><a href="#" class="link-black text-sm"><i class="fa fa-share margin-r-5"></i> Share</a></li>
                <li><a href="#" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i> Like</a></li>
                <li class="pull-right"><a href="#" class="link-black text-sm"><i class="fa fa-comments-o margin-r-5"></i> Comments (5)</a></li>
              </ul>

              <input class="form-control input-sm" type="text" placeholder="Type a comment">
            </div><!-- /.post -->

            <!-- Post -->
            <div class="post clearfix">
              <div class='user-block'>
                <img class='img-circle img-bordered-sm' src='<?= $directoryAsset ?>/img/user7-128x128.jpg' alt='user image'>
                <span class='username'>
                  <a href="#">Sarah Ross</a>
                  <a href='#' class='pull-right btn-box-tool'><i class='fa fa-times'></i></a>
                </span>
                <span class='description'>Sent you a message - 3 days ago</span>
              </div><!-- /.user-block -->
              <p>
                Lorem ipsum represents a long-held tradition for designers,
                typographers and the like. Some people hate it and argue for
                its demise, but others ignore the hate as they create awesome
                tools to help create filler text for everyone from bacon lovers
                to Charlie Sheen fans.
              </p>

              <form class='form-horizontal'>
                <div class='form-group margin-bottom-none'>
                  <div class='col-sm-9'>
                    <input class="form-control input-sm" placeholder="Response">
                  </div>                          
                  <div class='col-sm-3'>
                    <button class='btn btn-danger pull-right btn-block btn-sm'>Send</button>
                  </div>                          
                </div>                        
              </form>
            </div><!-- /.post -->
          </div><!-- /.tab-pane -->

          <div class="active tab-pane" id="offers">
            <?= $this->render('@backend/modules/offers/views/offer/list', ['model' => $model->buyer->favorites]) ?>
          </div>

          <div class="tab-pane" id="settings">
            <?php
              $profileForm = new \backend\models\form\ProfileForm();
              $profileForm->user = \backend\models\User::findOne($model->userId);
            ?>
            <?= $this->render('@backend/views/user/_form', [
              'model' => $profileForm,
            ]) ?>
          </div><!-- /.tab-pane -->

        </div><!-- /.tab-content -->
      </div><!-- /.nav-tabs-custom -->
    </div><!-- /.col -->
  </div><!-- /.row -->

</div>

