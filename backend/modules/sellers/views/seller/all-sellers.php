<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Empresas Cadastradas';

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/bower') . '/adminlte/dist';
$currentUser = Yii::$app->user->identity;
$myImages = Url::to('@web/img/');
?>

<?php
  $statusColors = ['ACT' => 'green', 'PEN' => 'yellow', 'BAN' => 'red', 'REM' => 'red'];
  
  $sellersChunks = array_chunk($model, 3);

  foreach($sellersChunks as $divItem):
    echo '<div class="row">';
    foreach ($divItem as $seller):
      if (strpos($seller->picture->thumbnail, 'generic-avatar') !== false) {
        $seller->picture->thumbnail = $myImages . '/generic-avatar.png';
      }

      if (strpos($seller->picture->cover, 'generic-cover') !== false) {
        $seller->picture->cover = $myImages . '/generic-cover.jpg';
      }
?>
      <section class="col-lg-4">
        <?= \machour\yii2\adminlte\widgets\Box::begin([
          'type' => 'box-widget',
          'color' => '',
          'noPadding' => false,
          'header' => [
            'title' => $seller->name,
            //'class' => 'with-border',
            'tools' => '{collapse}',
          ],
          'body' => [
            'class' => 'box-profile',
          ],
        ]); ?>
          <?= Html::img($seller->picture->thumbnail, ['class' => 'profile-user-img img-responsive img-circle', 'alt' => 'User Image']) ?>
          <h3 class="profile-username text-center"><?= $seller->name ?></h3>
          <p class="text-muted text-center"><?= $seller->email ?></p>
          <!-- Html::a('Seguir', ['create'], ['class' => 'btn btn-primary btn-block']) -->
          <div class="row">
            <div class="col-sm-4 border-right">
              <div class="description-block">
                <h5 class="description-header">Nenhum</h5>
                <span class="description-text">Brinde</span>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-4 border-right">
              <div class="description-block">
                <?php $flr = count($seller->followers); ?>
                <h5 class="description-header"><?= ($flr == 0) ? 'Nenhum' : $flr ?></h5>
                <span class="description-text"><?= ($flr > 1) ? 'Seguidores' : 'Seguidor' ?></span>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-4">
              <div class="description-block">
                <?php $cnt = count($seller->offers); ?>
                <h5 class="description-header"><?= ($cnt == 0) ? 'Nenhuma' : $cnt ?></h5>
                <span class="description-text"><?= ($cnt > 1) ? 'OFERTAS' : 'OFERTA' ?></span>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
          </div>
        <?= \machour\yii2\adminlte\widgets\Box::footer(); ?>
          <ul class="nav nav-stacked">
            <li><?= Html::a('<b>Gerenciar</b>', ['seller/view', 'id' => $seller->sellerId]) ?></li>
          </ul>
        <?= \machour\yii2\adminlte\widgets\Box::end(); ?>

      </section>
<?php
    endforeach;
    echo '</div><!-- /.row -->';
  endforeach;
?>