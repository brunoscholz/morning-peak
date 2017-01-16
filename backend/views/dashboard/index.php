<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Painel de Controle';

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/bower') . '/adminlte/dist';
$currentUser = Yii::$app->user->identity;
$myImages = Url::to('@web/img/');
?>

<!-- Small boxes (Stat box) -->
<div class="row">
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <?= \machour\yii2\adminlte\widgets\SmallBox::widget([
      'color' => 'bg-aqua-active',
      'icon' => 'fa-building',
      'header' => Count($currentUser->sellers),
      'text' => 'Empresas cadastradas',
      'footerUrl' => '',
      'footerText' => '',
    ]) ?>
  </div><!-- ./col -->

  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <?php
      $tFlw = ArrayHelper::map($currentUser->sellers,'sellerId', function($model, $defaultValue) { return count($model->followers); });
      $tOff = ArrayHelper::map($currentUser->sellers,'sellerId', function($model, $defaultValue) { return count($model->offers); });
      $tFlw = array_sum($tFlw);
      $tOff = array_sum($tOff);
    ?>
    <?= \machour\yii2\adminlte\widgets\SmallBox::widget([
      'color' => 'bg-yellow',
      'icon' => 'fa-shopping-bag',
      'header' => $tOff . ' ',
      'text' => 'Ofertas',
      'footerUrl' => '',
      'footerText' => '',
    ]) ?>
  </div><!-- ./col -->

  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <?= \machour\yii2\adminlte\widgets\SmallBox::widget([
      'color' => 'bg-green-gradient',
      'icon' => 'fa-user',
      'header' => $tFlw . ' ',
      'text' => 'Seguidores',
      'footerUrl' => '',
      'footerText' => '',
    ]) ?>
  </div><!-- ./col -->

  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
  </div>
</div><!-- /.row -->  

<?php
  $statusColors = ['ACT' => 'green', 'PEN' => 'yellow', 'BAN' => 'red', 'REM' => 'red'];
  
  $sellersChunks = array_chunk($currentUser->sellers, 3);

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

<div class="row">
  <!-- USERS LIST -->
  <section class="col-lg-4 connectedSortable">
    <?= \machour\yii2\adminlte\widgets\Box::begin([
      'type' => 'box-danger',
      'color' => '',
      'noPadding' => true,
      'header' => [
        'title' => 'Últimos Seguidores',
        'label-tool' => '8 Novos',
        'tools' => '{collapse}',
      ],
    ]); ?>
    <!-- box body -->
    <ul class="users-list clearfix" style="min-height: 250px; width: 100%;">
    <?php
      $users = [];
      foreach ($currentUser->sellers as $seller)
        foreach ($seller->followers as $flw)
          $users[$flw->userId] = $flw;

      foreach ($users as $key => $flw):
    ?>
      <li>
        <img src="<?= $flw->user->buyer->picture->thumbnail ?>" alt="User Image">
        <a class="users-list-name" href="#"><?= $flw->user->buyer->name ?></a>
        <span class="users-list-date">Today</span>
      </li>
    <?php endforeach; ?>
    </ul><!-- /.users-list -->

    <?= \machour\yii2\adminlte\widgets\Box::footer(); ?>
      <div class="row text-center">
        <a href="javascript::" class="uppercase">Ver Todos</a>
      </div><!-- /.row -->
    <?= \machour\yii2\adminlte\widgets\Box::end(); ?>
  </section>

  <section class="col-lg-4 connectedSortable">
    <!-- TABLE: LATEST ORDERS -->
    <?= \machour\yii2\adminlte\widgets\Box::begin([
      'type' => 'box-info',
      'color' => '',
      'noPadding' => false,
      'header' => [
        'title' => 'Últimos Brindes',
        'class' => 'with-border',
        'tools' => '{collapse}',
      ],
    ]); ?>
    <!-- box body -->
    <div class="table-responsive" style="min-height: 250px; width: 100%;">
      <table class="table no-margin">
        <thead>
          <tr>
            <th>Data</th>
            <th>Oferta</th>
            <th>Status</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          <!-- <tr>
            <td><a href="pages/examples/invoice.html">OR9842</a></td>
            <td>Call of Duty IV</td>
            <td><span class="label label-success">Shipped</span></td>
            <td><div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63</div></td>
          </tr> -->
        </tbody>
      </table>
    </div><!-- /.table-responsive -->
    <?= \machour\yii2\adminlte\widgets\Box::footer(); ?>
        <a href="javascript::;" class="btn btn-sm btn-info btn-flat pull-left">Criar Brinde</a>
        <a href="javascript::;" class="btn btn-sm btn-default btn-flat pull-right">Ver Todos</a>
    <?= \machour\yii2\adminlte\widgets\Box::end(); ?>
  </section>

  <section class="col-lg-4 connectedSortable">
    <!-- PRODUCT LIST -->
    <?= \machour\yii2\adminlte\widgets\Box::begin([
      'type' => 'box-primary',
      'color' => '',
      'noPadding' => false,
      'header' => [
        'title' => 'Ofertas Recentes',
        'class' => 'with-border',
        'tools' => '{collapse}',
      ],
    ]); ?>
    <ul class="products-list product-list-in-box" style="min-height: 250px; width: 100%;">
      <?php
        $offers = [];
        foreach ($currentUser->sellers as $seller)
          foreach ($seller->offers as $off)
            $offers[$off->offerId] = $off;

        ArrayHelper::multisort($offers, 'updatedAt', SORT_DESC);

        foreach ($offers as $key => $off):
          if (strpos($off->picture->cover, 'generic-cover') !== false) {
            $off->picture->cover = $myImages . '/generic-cover.jpg';
          }
      ?>
        <li class="item">
          <div class="product-img">
            <img src="<?= $off->picture->cover ?>" alt="Offer Image">
          </div>
          <div class="product-info">
            <?= Html::a(
              $off->item->title . '<span class="label label-warning pull-right">R$ '.$off->pricePerUnit .'</span>',
              ['offer/view', 'id' => $off->offerId],
              ['class' => 'product-title']
            ) ?>
            <span class="product-description">
              <?= $off->description ?>
            </span>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
    <?= \machour\yii2\adminlte\widgets\Box::footer(); ?>
        <div class="row text-center">
          <a href="javascript::;" class="uppercase">Ver Todas</a>
        </div><!-- /.row -->
    <?= \machour\yii2\adminlte\widgets\Box::end(); ?>
  </section>

</div><!-- /.row -->
