<?php

use yii\helpers\Html;
use yii\helpers\Url;
use \machour\yii2\adminlte\widgets\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/bower') . '/adminlte/dist';
$currentUser = Yii::$app->user->identity;
$myImages = Url::to('@web/img/');

$this->title = 'Transações';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaction-index">

    <?= \machour\yii2\adminlte\widgets\Box::begin([
      'type' => 'box-primary',
      'color' => '',
      'noPadding' => false,
      'header' => [
        'title' => $this->title,
        'class' => 'with-border',
        'tools' => '',
      ],
    ]); ?>
    
    <?= GridView::widget([
        'id' => 'transaction-table',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            'transactionId',
            [
                'attribute'=>'type',
                'label'=>'Tipo',
                'format'=>'html',
                'value' => function($data) {
                    $arrAction = ArrayHelper::map(\common\models\ActionReference::find()->asArray()->all(), 'actionReferenceId', 'actionType');
                    return $data->type > 0 ? $arrAction[$data->type] : 'N/A';
                },
                'filter' => Html::activeDropDownList($searchModel, 'type', ArrayHelper::map(\common\models\ActionReference::find()->asArray()->all(), 'actionReferenceId', 'actionType'),['class'=>'form-control','prompt' => 'Selecione um tipo']),
            ],
            'senderId',
            'recipientId',
            [
                'attribute' => 'amount',
                'label' => 'Total',
                'value' => function ($data) {
                    return 'OTK ' . number_format($data->amount, 8, ',', '.');
                },
                //'filter' => Html::activeDropDownList($searchModel, 'sellerId', ArrayHelper::map(\common\models\Seller::find()->asArray()->all(), 'sellerId', 'name'),['class'=>'form-control','prompt' => 'Selecione uma empresa']),
                'filter' => ["10"=>"até OTK 10", "20"=>"até OTK 20", "50"=>"até OTK 50", "100"=>"até OTK 100", "200"=>"até OTK 200", "201"=>"mais que OTK 200"],
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?= \machour\yii2\adminlte\widgets\Box::end(); ?>

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
  //'type' => 'Line', 'options' => [ 'height' => 400, 'width' => 400 ], 'data' => [ 'labels' => ["January", "February", "March", "April", "May", "June", "July"], 'datasets' => [ [ 'fillColor' => "rgba(220,220,220,0.5)", 'strokeColor' => "rgba(220,220,220,1)", 'pointColor' => "rgba(220,220,220,1)", 'pointStrokeColor' => "#fff", 'data' => [65, 59, 90, 81, 56, 55, 40] ], [ 'fillColor' => "rgba(151,187,205,0.5)", 'strokeColor' => "rgba(151,187,205,1)", 'pointColor' => "rgba(151,187,205,1)", 'pointStrokeColor' => "#fff", 'data' => [28, 48, 40, 19, 96, 27, 100] ] ] ]
?>
<div class="row">
  <section class="col-lg-4 connectedSortable">
    <?= \machour\yii2\adminlte\widgets\Box::begin([
      'type' => 'box-default',
      'color' => '',
      'noPadding' => false,
      'header' => [
        'title' => 'Flot or morris',
        'class' => 'with-border',
        'tools' => '{collapse}{remove}',
      ],
    ]); ?>
      <div class="chart-responsive">
        <?php
          $sin = [];
          $cos = [];
          for ($i = 0; $i < 14; $i += 0.5) {
            $sin[] = [$i, sin($i)];
            $cos[] = [$i, cos($i)];
          }
          $line_data1 = [
            'data' => $sin,
            'color' => "#3c8dbc",
          ];
          $line_data2 = [
            'data' => $cos,
            'color' => "#00c0ef",
          ];
        ?>
        <?= \machour\yii2\adminlte\widgets\Flot::widget([
          'options' => [
            'grid' => [
              'hoverable' => true,
              'borderColor' => "#f3f3f3",
              'borderWidth' => 1,
              'tickColor' => "#f3f3f3",
            ],
            'series' => [
              'shadowSize' => 0, // Drawing is faster without shadows
              'lines' => [
                'show' => true,
              ],
              'points' => [
                'show' => true,
              ],
            ],
            'lines' => [
              'fill' => false, //Converts the line chart to area chart
              'color' => ["#3c8dbc", "#f56954"],
            ],
            'yaxis' => [
              'show' => true
            ],
            'xaxis' => [
              'show' => true
            ]
          ],
          'htmlOptions' => ['id'=>'interactive', 'style' => 'height: 250px;'],
          'data' => [$line_data1, $line_data2],
        ]); ?>
      </div><!-- ./chart-responsive -->
      <?= \machour\yii2\adminlte\widgets\Box::footer(); ?>
        <ul class="nav nav-pills nav-stacked">
          <li><a href="#">United States of America <span class="pull-right text-red"><i class="fa fa-angle-down"></i> 12%</span></a></li>
          <li><a href="#">India <span class="pull-right text-green"><i class="fa fa-angle-up"></i> 4%</span></a></li>
          <li><a href="#">China <span class="pull-right text-yellow"><i class="fa fa-angle-left"></i> 0%</span></a></li>
        </ul>
    <?= \machour\yii2\adminlte\widgets\Box::end(); ?>
  </section>
</div>

<div class="row">
  <section class="col-lg-4 connectedSortable">
    <?= \machour\yii2\adminlte\widgets\Box::begin([
      'type' => 'box-primary',
      'color' => '',
      'noPadding' => false,
      'header' => [
        'title' => 'Area',
        'class' => 'with-border',
        'tools' => '{collapse}{remove}',
      ],
    ]); ?>
      <div class="chart-responsive">
        <?php
            $begining = date('Y-m-d 00:00:00', strtotime('2017-01-01 00:00:00'));
            $today = date('Y-m-d G:i:s');
            //$tomorrow = date('Y-m-d G:i:s', strtotime($today.' +1day'));
            //$end =date("Y-m-d G:i:s",strtotime($date.' +1day'));
            $counter = date("Y-m-d G:i:s", strtotime($begining));
            //'zZN6prD6rzxEhg8sDQz1j'

            $sets = [];
            $i = 1;
            while($counter <= $today)
            {
                //$sets[] = [$counter , rand(20, 100)];
                $sets[] = [$i , rand(20, 100)];
                $counter = date('Y-m-d G:i:s', strtotime($counter.' +1day'));
                $i++;
            }

            //var_dump($sets);
        ?>
        <?= \machour\yii2\adminlte\widgets\flot::widget([
          'options' => [
            'grid' => [
              'borderWidth' => 0,
            ],
            'series' => [
              'shadowSize' => 0, // Drawing is faster without shadows
              'color' => "#00c0ef",
            ],
            'lines' => [
              'fill' => true, //Converts the line chart to area chart
            ],
            'yaxis' => [
              'show' => true
            ],
            'xaxis' => [
              'show' => true
            ]
          ],
          'htmlOptions' => ['id'=>'revenue', 'style' => 'height: 250px;'],
          //'data' => [[[1, 88.0], [1, 93.3], [1, 102.0], [5, 108.5], [6, 115.7], [7, 115.6], [8, 124.6], [9, 130.3], [10, 134.3], [11, 141.4], [12, 146.5], [13, 151.7], [14, 159.9], [15, 165.4], [16, 167.8], [17, 168.7], [18, 169.5], [19, 168.0]]],
          'data' => [$sets],
        ]); ?>
      </div><!-- ./chart-responsive -->
    <?= \machour\yii2\adminlte\widgets\Box::end(); ?>
  </section>

  <section class="col-lg-4 connectedSortable">
    <?= \machour\yii2\adminlte\widgets\Box::begin([
      'type' => 'box-danger',
      'color' => '',
      'noPadding' => false,
      'header' => [
        'title' => 'Bars',
        'class' => 'with-border',
        'tools' => '{collapse}{remove}',
      ],
    ]); ?>
      <div class="chart-responsive">
        <?= \machour\yii2\adminlte\widgets\flot::widget([
          'options' => [
            'grid' => [
              'borderWidth' => 1,
              'borderColor' => "#f3f3f3",
              'tickColor' => "#f3f3f3",
            ],
            'series' => [
              'bars' => [
                'show' => true,
                'barWidth' => 0.5,
                'align' => "center"
              ],
            ],
            'xaxis' => [
              'mode' => 'categories',
              'tickLength' => 0,
            ]
          ],
          'htmlOptions' => ['id'=>'bars', 'style' => 'height: 250px;'],
          'plugins' => [
            \machour\flot\Plugin::CATEGORIES
          ],
          'data' => [['data' => [["January", 10], ["February", 8], ["March", 4], ["April", 13], ["May", 17], ["June", 9]], 'color' => "#3c8dbc"]],
        ]); ?>
      </div><!-- ./chart-responsive -->
    <?= \machour\yii2\adminlte\widgets\Box::end(); ?>
  </section>

  <section class="col-lg-4 connectedSortable">
    <?= \machour\yii2\adminlte\widgets\Box::begin([
      'type' => 'box-success',
      'color' => '',
      'noPadding' => false,
      'header' => [
        'title' => 'Donut',
        'class' => 'with-border',
        'tools' => '{collapse}{remove}',
      ],
    ]); ?>
      <div class="chart-responsive">
        <?php
$format_func = <<<'EOT'
(label, series) => {return '<div style="font-size:13px;text-align:center;padding:2px;color:#fff;font-weight: 600;">'+label+'<br>'+Math.round(series.percent)+"%</div>";}
EOT;
        ?>
        <?= \machour\yii2\adminlte\widgets\flot::widget([
          'options' => [
            'series' => [
              'pie' => [
                'show' => true,
                'radius' => 1,
                'innerRadius' => 0.5,
                'label' => [
                  'show' => true,
                  'radius' => 2/3,
                  'formatter' => new \yii\web\JsExpression("function(label, series) { return '<div style=\"font-size:13px;text-align:center;padding:2px;color:#fff;font-weight: 600;\">'+label+'<br>'+Math.round(series.percent)+'%</div>';}"),
                  'threshold' => 0.1,
                ],
              ],
            ],
            'legend' => [
              'show' => false,
            ],
          ],
          'htmlOptions' => ['id'=>'donut', 'style' => 'height: 250px;'],
          'plugins' => [
            \machour\flot\Plugin::PIE,
            \machour\flot\Plugin::THRESHOLD,
          ],
          'data' => [['label' => "Series2", 'data' => 30, 'color' => "#3c8dbc"], ['label' => "Series3", 'data' => 20, 'color' => "#0073b7"], ['label' => "Series4", 'data' => 50, 'color' => "#00c0ef"]],
        ]); ?>
      </div><!-- ./chart-responsive -->
    <?= \machour\yii2\adminlte\widgets\Box::end(); ?>
  </section>
</div>

</div>
