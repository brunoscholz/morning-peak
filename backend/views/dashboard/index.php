<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use dosamigos\chartjs\ChartJs;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Painel de Controle';

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
$currentUser = Yii::$app->user->identity;
//var_dump(Yii::$app->user->identity->sellers);

/*Html::img('@web/img/visa.png', ['alt' => 'My logo', 'width'=>'100'])
Html::a('Criar Prestadora', ['create'], ['class' => 'btn btn-success'])*/

/*
\machour\yii2\adminlte\widgets\Callout::begin([]);
<div id="world-map" style="height: 250px; width: 100%;">
  ANY BOX CONTENT HERE
</div>
\machour\yii2\adminlte\widgets\Callout::end()
\machour\yii2\adminlte\widgets\InfoBox::widget([
  'text' => 'InfoBox',
  'number' => 100,
]);
*/
?>

<!-- Small boxes (Stat box) -->
<div class="row">
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <?= \machour\yii2\adminlte\widgets\SmallBox::widget([
      'color' => 'bg-aqua',
      'icon' => 'fa-exclamation-triangle',
      'header' => Count($currentUser->sellers),
      'text' => 'Total number of incidents',
      'footerUrl' => Url::to(['site/index']),
      'footerText' => 'More Info ',
    ]) ?>
  </div><!-- ./col -->

  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <?= \machour\yii2\adminlte\widgets\SmallBox::widget([
      'color' => 'bg-green',
      'icon' => 'fa-bars',
      'header' => '53<sup style="font-size: 20px">%</sup>',
      'text' => 'Bounce Rate',
      'footerUrl' => Url::to(['site/index']),
      'footerText' => 'More Info ',
    ]) ?>
  </div><!-- ./col -->

  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <?= \machour\yii2\adminlte\widgets\SmallBox::widget([
      'color' => 'bg-yellow',
      'icon' => 'fa-person',
      'header' => 44,
      'text' => 'User Registrations',
      'footerUrl' => Url::to(['site/index']),
      'footerText' => 'More Info ',
    ]) ?>
  </div><!-- ./col -->

  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <?= \machour\yii2\adminlte\widgets\SmallBox::widget([
      'color' => 'bg-red',
      'icon' => 'fa-person-add',
      'header' => 65,
      'text' => 'Unique Visitors',
      'footerUrl' => Url::to(['site/index']),
      'footerText' => 'More Info ',
    ]) ?>
  </div><!-- ./col -->
</div><!-- /.row -->  

<?php
  $statusColors = ['ATV' => 'green', 'PEN' => 'yellow', 'BAN' => 'red', 'REM' => 'red'];
  
  $sellersChunks = array_chunk($currentUser->sellers, 3);
  $rows = ceil((count($currentUser->sellers) / 2));
  for($i = 0; $i < $rows; $i++):
    echo '<div class="row">';
    foreach ($sellersChunks[0] as $seller):
?>
      <section class="col-lg-4 connectedSortable">
        <?= \machour\yii2\adminlte\widgets\Box::begin([
          'color' => 'bg-'.$statusColors[$seller->status].'-gradient',
          'noPadding' => false,
          'header' => [
            'title' => $seller->name,
            'tools' => '{refresh}{collapse}{remove}',
          ],
        ]); ?>
        <!-- box body -->
        <div id="world-map" style="height: 250px; width: 100%;">
          <p><?= $seller->email ?></p>
          <p><?= $seller->website; ?></p>
          <p><?= $seller->about; ?></p>
        </div>

        <?= \machour\yii2\adminlte\widgets\Box::footer(); ?>
          <div class="row">
            <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
              <div id="sparkline-1"></div>
              <div class="knob-label">Editar</div>
            </div><!-- ./col -->
            <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
              <div id="sparkline-2"></div>
              <div class="knob-label">Ver</div>
            </div><!-- ./col -->
            <div class="col-xs-4 text-center">
              <div id="sparkline-3"></div>
              <div class="knob-label">--</div>
            </div><!-- ./col -->
          </div><!-- /.row -->
        <?= \machour\yii2\adminlte\widgets\Box::end(); ?>
      </section>
<?php
    endforeach;
    echo '</div><!-- /.row (sellers row #'.($i + 1).') -->';
  endfor;
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
        'tools' => '{collapse}{remove}',
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
      <li>
        <img src="<?= $directoryAsset ?>/img/user1-128x128.jpg" alt="User Image">
        <a class="users-list-name" href="#">Alexander Pierce</a>
        <span class="users-list-date">Today</span>
      </li>
      <li>
        <img src="<?= $directoryAsset ?>/img/user8-128x128.jpg" alt="User Image">
        <a class="users-list-name" href="#">Norman</a>
        <span class="users-list-date">Yesterday</span>
      </li>
      <li>
        <img src="<?= $directoryAsset ?>/img/user7-128x128.jpg" alt="User Image">
        <a class="users-list-name" href="#">Jane</a>
        <span class="users-list-date">12 Jan</span>
      </li>
      <li>
        <img src="<?= $directoryAsset ?>/img/user6-128x128.jpg" alt="User Image">
        <a class="users-list-name" href="#">John</a>
        <span class="users-list-date">12 Jan</span>
      </li>
      <li>
        <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" alt="User Image">
        <a class="users-list-name" href="#">Alexander</a>
        <span class="users-list-date">13 Jan</span>
      </li>
      <li>
        <img src="<?= $directoryAsset ?>/img/user5-128x128.jpg" alt="User Image">
        <a class="users-list-name" href="#">Sarah</a>
        <span class="users-list-date">14 Jan</span>
      </li>
      <li>
        <img src="<?= $directoryAsset ?>/img/user4-128x128.jpg" alt="User Image">
        <a class="users-list-name" href="#">Nora</a>
        <span class="users-list-date">15 Jan</span>
      </li>
      <li>
        <img src="<?= $directoryAsset ?>/img/user3-128x128.jpg" alt="User Image">
        <a class="users-list-name" href="#">Nadia</a>
        <span class="users-list-date">15 Jan</span>
      </li>
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
        'title' => 'Latest Orders',
        'class' => 'with-border',
        'tools' => '{collapse}{remove}',
      ],
    ]); ?>
    <!-- box body -->
    <div class="table-responsive">
      <table class="table no-margin">
        <thead>
          <tr>
            <th>Order ID</th>
            <th>Item</th>
            <th>Status</th>
            <th>Popularity</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><a href="pages/examples/invoice.html">OR9842</a></td>
            <td>Call of Duty IV</td>
            <td><span class="label label-success">Shipped</span></td>
            <td><div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63</div></td>
          </tr>
          <tr>
            <td><a href="pages/examples/invoice.html">OR1848</a></td>
            <td>Samsung Smart TV</td>
            <td><span class="label label-warning">Pending</span></td>
            <td><div class="sparkbar" data-color="#f39c12" data-height="20">90,80,-90,70,61,-83,68</div></td>
          </tr>
          <tr>
            <td><a href="pages/examples/invoice.html">OR7429</a></td>
            <td>iPhone 6 Plus</td>
            <td><span class="label label-danger">Delivered</span></td>
            <td><div class="sparkbar" data-color="#f56954" data-height="20">90,-80,90,70,-61,83,63</div></td>
          </tr>
          <tr>
            <td><a href="pages/examples/invoice.html">OR7429</a></td>
            <td>Samsung Smart TV</td>
            <td><span class="label label-info">Processing</span></td>
            <td><div class="sparkbar" data-color="#00c0ef" data-height="20">90,80,-90,70,-61,83,63</div></td>
          </tr>
          <tr>
            <td><a href="pages/examples/invoice.html">OR1848</a></td>
            <td>Samsung Smart TV</td>
            <td><span class="label label-warning">Pending</span></td>
            <td><div class="sparkbar" data-color="#f39c12" data-height="20">90,80,-90,70,61,-83,68</div></td>
          </tr>
          <tr>
            <td><a href="pages/examples/invoice.html">OR7429</a></td>
            <td>iPhone 6 Plus</td>
            <td><span class="label label-danger">Delivered</span></td>
            <td><div class="sparkbar" data-color="#f56954" data-height="20">90,-80,90,70,-61,83,63</div></td>
          </tr>
          <tr>
            <td><a href="pages/examples/invoice.html">OR9842</a></td>
            <td>Call of Duty IV</td>
            <td><span class="label label-success">Shipped</span></td>
            <td><div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63</div></td>
          </tr>
        </tbody>
      </table>
    </div><!-- /.table-responsive -->
    <?= \machour\yii2\adminlte\widgets\Box::footer(); ?>
        <a href="javascript::;" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
        <a href="javascript::;" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>
    <?= \machour\yii2\adminlte\widgets\Box::end(); ?>
  </section>

  <section class="col-lg-4 connectedSortable">
    <!-- PRODUCT LIST -->
    <?= \machour\yii2\adminlte\widgets\Box::begin([
      'type' => 'box-primary',
      'color' => '',
      'noPadding' => false,
      'header' => [
        'title' => 'Recently Added Products',
        'class' => 'with-border',
        'tools' => '{collapse}{remove}',
      ],
    ]); ?>
    <ul class="products-list product-list-in-box">
      <li class="item">
        <div class="product-img">
          <img src="<?= $directoryAsset ?>/img/default-50x50.gif" alt="Product Image">
        </div>
        <div class="product-info">
          <a href="javascript::;" class="product-title">Samsung TV <span class="label label-warning pull-right">$1800</span></a>
          <span class="product-description">
            Samsung 32" 1080p 60Hz LED Smart HDTV.
          </span>
        </div>
      </li><!-- /.item -->
      <li class="item">
        <div class="product-img">
          <img src="<?= $directoryAsset ?>/img/default-50x50.gif" alt="Product Image">
        </div>
        <div class="product-info">
          <a href="javascript::;" class="product-title">Bicycle <span class="label label-info pull-right">$700</span></a>
          <span class="product-description">
            26" Mongoose Dolomite Men's 7-speed, Navy Blue.
          </span>
        </div>
      </li><!-- /.item -->
      <li class="item">
        <div class="product-img">
          <img src="<?= $directoryAsset ?>/img/default-50x50.gif" alt="Product Image">
        </div>
        <div class="product-info">
          <a href="javascript::;" class="product-title">Xbox One <span class="label label-danger pull-right">$350</span></a>
          <span class="product-description">
            Xbox One Console Bundle with Halo Master Chief Collection.
          </span>
        </div>
      </li><!-- /.item -->
      <li class="item">
        <div class="product-img">
          <img src="<?= $directoryAsset ?>/img/default-50x50.gif" alt="Product Image">
        </div>
        <div class="product-info">
          <a href="javascript::;" class="product-title">PlayStation 4 <span class="label label-success pull-right">$399</span></a>
          <span class="product-description">
            PlayStation 4 500GB Console (PS4)
          </span>
        </div>
      </li><!-- /.item -->
    </ul>
    <?= \machour\yii2\adminlte\widgets\Box::footer(); ?>
        <div class="row text-center">
          <a href="javascript::;" class="uppercase">View All Products</a>
        </div><!-- /.row -->
    <?= \machour\yii2\adminlte\widgets\Box::end(); ?>
  </section>

</div><!-- /.row -->

<div class="row>">
  <section class="col-lg-4 connectedSortable">
    <?= \machour\yii2\adminlte\widgets\InfoBox::widget([
      'color' => 'bg-yellow',
      'text' => 'Inventory',
      'number' => '5,200',
      'progress' => 50,
      'progressText' => '50% increase in 45 Days',
    ]); ?>
  </section>

  <section class="col-lg-4 connectedSortable">
    <!-- CHART TEST -->
    <?php
      $data = [
        'labels' => ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
        'datasets' => [
          [
            'label'=> '# of Votes',
            'data' => [12, 19, 3, 5, 2, 3],
            'backgroundColor' => [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            'borderColor' => [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            'borderWidth' => 1
          ]
        ]
      ];
    ?>
    <?= \machour\yii2\adminlte\widgets\Box::begin([
      'type' => 'box-default',
      'color' => '',
      'noPadding' => false,
      'header' => [
        'title' => 'Recently Added Products',
        'class' => 'with-border',
        'tools' => '{collapse}{remove}',
      ],
    ]); ?>
      <div class="row">
        <div class="col-md-8">
          <div class="chart-responsive">
            <?= ChartJs::widget([
              'type' => 'Line', 'options' => [ 'height' => 400, 'width' => 400 ], 'data' => [ 'labels' => ["January", "February", "March", "April", "May", "June", "July"], 'datasets' => [ [ 'fillColor' => "rgba(220,220,220,0.5)", 'strokeColor' => "rgba(220,220,220,1)", 'pointColor' => "rgba(220,220,220,1)", 'pointStrokeColor' => "#fff", 'data' => [65, 59, 90, 81, 56, 55, 40] ], [ 'fillColor' => "rgba(151,187,205,0.5)", 'strokeColor' => "rgba(151,187,205,1)", 'pointColor' => "rgba(151,187,205,1)", 'pointStrokeColor' => "#fff", 'data' => [28, 48, 40, 19, 96, 27, 100] ] ] ]
            ]); ?>
          </div><!-- ./chart-responsive -->
        </div><!-- /.col -->
        <div class="col-md-4">
          <ul class="chart-legend clearfix">
            <li><i class="fa fa-circle-o text-red"></i> Chrome</li>
            <li><i class="fa fa-circle-o text-green"></i> IE</li>
            <li><i class="fa fa-circle-o text-yellow"></i> FireFox</li>
            <li><i class="fa fa-circle-o text-aqua"></i> Safari</li>
            <li><i class="fa fa-circle-o text-light-blue"></i> Opera</li>
            <li><i class="fa fa-circle-o text-gray"></i> Navigator</li>
          </ul>
        </div><!-- /.col -->
      </div><!-- /.row -->
      <?= \machour\yii2\adminlte\widgets\Box::footer(); ?>
      <ul class="nav nav-pills nav-stacked">
          <li><a href="#">United States of America <span class="pull-right text-red"><i class="fa fa-angle-down"></i> 12%</span></a></li>
          <li><a href="#">India <span class="pull-right text-green"><i class="fa fa-angle-up"></i> 4%</span></a></li>
          <li><a href="#">China <span class="pull-right text-yellow"><i class="fa fa-angle-left"></i> 0%</span></a></li>
        </ul>
    <?= \machour\yii2\adminlte\widgets\Box::end(); ?>

  </section>

  <section class="col-lg-4 connectedSortable">
    <div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">Browser Usage</h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div><!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-8">
            <div class="chart-responsive">
              <canvas id="pieChart" height="150"></canvas>
            </div><!-- ./chart-responsive -->
          </div><!-- /.col -->
          <div class="col-md-4">
            <ul class="chart-legend clearfix">
              <li><i class="fa fa-circle-o text-red"></i> Chrome</li>
              <li><i class="fa fa-circle-o text-green"></i> IE</li>
              <li><i class="fa fa-circle-o text-yellow"></i> FireFox</li>
              <li><i class="fa fa-circle-o text-aqua"></i> Safari</li>
              <li><i class="fa fa-circle-o text-light-blue"></i> Opera</li>
              <li><i class="fa fa-circle-o text-gray"></i> Navigator</li>
            </ul>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.box-body -->
      <div class="box-footer no-padding">
        <ul class="nav nav-pills nav-stacked">
          <li><a href="#">United States of America <span class="pull-right text-red"><i class="fa fa-angle-down"></i> 12%</span></a></li>
          <li><a href="#">India <span class="pull-right text-green"><i class="fa fa-angle-up"></i> 4%</span></a></li>
          <li><a href="#">China <span class="pull-right text-yellow"><i class="fa fa-angle-left"></i> 0%</span></a></li>
        </ul>
      </div><!-- /.footer -->
    </div><!-- /.box -->
  </section>

  <section class="col-lg-4 connectedSortable">
    <!-- DIRECT CHAT -->
    <div class="box box-warning direct-chat direct-chat-warning">
      <div class="box-header with-border">
        <h3 class="box-title">Direct Chat</h3>
        <div class="box-tools pull-right">
          <span data-toggle="tooltip" title="3 New Messages" class="badge bg-yellow">3</span>
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button class="btn btn-box-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle"><i class="fa fa-comments"></i></button>
          <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div><!-- /.box-header -->
      <div class="box-body">
        <!-- Conversations are loaded here -->
        <div class="direct-chat-messages">
          <!-- Message. Default to the left -->
          <div class="direct-chat-msg">
            <div class="direct-chat-info clearfix">
              <span class="direct-chat-name pull-left">Alexander Pierce</span>
              <span class="direct-chat-timestamp pull-right">23 Jan 2:00 pm</span>
            </div><!-- /.direct-chat-info -->
            <img class="direct-chat-img" src="<?= $directoryAsset ?>/img/user1-128x128.jpg" alt="message user image"><!-- /.direct-chat-img -->
            <div class="direct-chat-text">
              Is this template really for free? That's unbelievable!
            </div><!-- /.direct-chat-text -->
          </div><!-- /.direct-chat-msg -->

          <!-- Message to the right -->
          <div class="direct-chat-msg right">
            <div class="direct-chat-info clearfix">
              <span class="direct-chat-name pull-right">Sarah Bullock</span>
              <span class="direct-chat-timestamp pull-left">23 Jan 2:05 pm</span>
            </div><!-- /.direct-chat-info -->
            <img class="direct-chat-img" src="<?= $directoryAsset ?>/img/user3-128x128.jpg" alt="message user image"><!-- /.direct-chat-img -->
            <div class="direct-chat-text">
              You better believe it!
            </div><!-- /.direct-chat-text -->
          </div><!-- /.direct-chat-msg -->

          <!-- Message. Default to the left -->
          <div class="direct-chat-msg">
            <div class="direct-chat-info clearfix">
              <span class="direct-chat-name pull-left">Alexander Pierce</span>
              <span class="direct-chat-timestamp pull-right">23 Jan 5:37 pm</span>
            </div><!-- /.direct-chat-info -->
            <img class="direct-chat-img" src="<?= $directoryAsset ?>/img/user1-128x128.jpg" alt="message user image"><!-- /.direct-chat-img -->
            <div class="direct-chat-text">
              Working with AdminLTE on a great new app! Wanna join?
            </div><!-- /.direct-chat-text -->
          </div><!-- /.direct-chat-msg -->

          <!-- Message to the right -->
          <div class="direct-chat-msg right">
            <div class="direct-chat-info clearfix">
              <span class="direct-chat-name pull-right">Sarah Bullock</span>
              <span class="direct-chat-timestamp pull-left">23 Jan 6:10 pm</span>
            </div><!-- /.direct-chat-info -->
            <img class="direct-chat-img" src="<?= $directoryAsset ?>/img/user3-128x128.jpg" alt="message user image"><!-- /.direct-chat-img -->
            <div class="direct-chat-text">
              I would love to.
            </div><!-- /.direct-chat-text -->
          </div><!-- /.direct-chat-msg -->
        </div><!--/.direct-chat-messages-->

        <!-- Contacts are loaded here -->
        <div class="direct-chat-contacts">
          <ul class="contacts-list">
            <li>
              <a href="#">
                <img class="contacts-list-img" src="<?= $directoryAsset ?>/img/user1-128x128.jpg">
                <div class="contacts-list-info">
                  <span class="contacts-list-name">
                    Count Dracula
                    <small class="contacts-list-date pull-right">2/28/2015</small>
                  </span>
                  <span class="contacts-list-msg">How have you been? I was...</span>
                </div><!-- /.contacts-list-info -->
              </a>
            </li><!-- End Contact Item -->
            <li>
              <a href="#">
                <img class="contacts-list-img" src="<?= $directoryAsset ?>/img/user7-128x128.jpg">
                <div class="contacts-list-info">
                  <span class="contacts-list-name">
                    Sarah Doe
                    <small class="contacts-list-date pull-right">2/23/2015</small>
                  </span>
                  <span class="contacts-list-msg">I will be waiting for...</span>
                </div><!-- /.contacts-list-info -->
              </a>
            </li><!-- End Contact Item -->
            <li>
              <a href="#">
                <img class="contacts-list-img" src="<?= $directoryAsset ?>/img/user3-128x128.jpg">
                <div class="contacts-list-info">
                  <span class="contacts-list-name">
                    Nadia Jolie
                    <small class="contacts-list-date pull-right">2/20/2015</small>
                  </span>
                  <span class="contacts-list-msg">I'll call you back at...</span>
                </div><!-- /.contacts-list-info -->
              </a>
            </li><!-- End Contact Item -->
            <li>
              <a href="#">
                <img class="contacts-list-img" src="<?= $directoryAsset ?>/img/user5-128x128.jpg">
                <div class="contacts-list-info">
                  <span class="contacts-list-name">
                    Nora S. Vans
                    <small class="contacts-list-date pull-right">2/10/2015</small>
                  </span>
                  <span class="contacts-list-msg">Where is your new...</span>
                </div><!-- /.contacts-list-info -->
              </a>
            </li><!-- End Contact Item -->
            <li>
              <a href="#">
                <img class="contacts-list-img" src="<?= $directoryAsset ?>/img/user6-128x128.jpg">
                <div class="contacts-list-info">
                  <span class="contacts-list-name">
                    John K.
                    <small class="contacts-list-date pull-right">1/27/2015</small>
                  </span>
                  <span class="contacts-list-msg">Can I take a look at...</span>
                </div><!-- /.contacts-list-info -->
              </a>
            </li><!-- End Contact Item -->
            <li>
              <a href="#">
                <img class="contacts-list-img" src="<?= $directoryAsset ?>/img/user8-128x128.jpg">
                <div class="contacts-list-info">
                  <span class="contacts-list-name">
                    Kenneth M.
                    <small class="contacts-list-date pull-right">1/4/2015</small>
                  </span>
                  <span class="contacts-list-msg">Never mind I found...</span>
                </div><!-- /.contacts-list-info -->
              </a>
            </li><!-- End Contact Item -->
          </ul><!-- /.contatcts-list -->
        </div><!-- /.direct-chat-pane -->
      </div><!-- /.box-body -->
      <div class="box-footer">
        <form action="#" method="post">
          <div class="input-group">
            <input type="text" name="message" placeholder="Type Message ..." class="form-control">
            <span class="input-group-btn">
              <button type="button" class="btn btn-warning btn-flat">Send</button>
            </span>
          </div>
        </form>
      </div><!-- /.box-footer-->
    </div><!--/.direct-chat -->
  </section>

</div><!-- /.row -->