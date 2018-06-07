<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use \machour\yii2\adminlte\widgets\GridView;
use backend\components\Utils;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuários';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="buyer-index">

  <div class="block">
    <div class="well text-center">
      <div id="w0" class="action-toolbar btn-toolbar">
        <div id="w1" class="btn-group">
          <?= Html::a('<i class="fa fa-plus"></i> Criar Usuário', ['/user/create'], ['class' => 'btn btn-default']) ?>
        </div>
      </div>
    </div>
  </div>

    <?= \machour\yii2\adminlte\widgets\Box::begin([
      'type' => 'box-primary',
      'color' => '',
      'noPadding' => false,
      'header' => [
        'title' => $this->title,
        'icon' => 'fa-users',
        'class' => 'with-border',
        'tools' => '{collapse}',
      ],
    ]); ?>

        <?= GridView::widget([
            'id' => 'buyer-table',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'name',
                [
                  'attribute'=>'about',
                  'format'=>'html',
                  'value' => function($data) {
                      return Utils::truncate($data->about, 30) . '...';
                  }
                ],
                'dob',
                'email:email',
                // 'gender',
                // 'title',
                // 'website',

                [
                  'class' => 'yii\grid\ActionColumn',
                  'template' => '{view} {update} {changestatus}',
                  'buttons' => [
                    'changestatus' => function ($url) {
                      return Html::a(
                        '<i class="glyphicon glyphicon-remove"></span>',
                        $url, 
                        [
                          'title' => 'Deactivate',
                          'data-pjax' => '0',
                        ]
                      );
                    },
                  ],
                ],
            ],
        ]); ?>

    <?= \machour\yii2\adminlte\widgets\Box::end(); ?>
        
</div>
