<?php

use yii\helpers\Html;
use \machour\yii2\adminlte\widgets\GridView;
use yii\helpers\ArrayHelper;
use backend\components\Utils;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel backend\models\SellerSearch */

$this->title = 'Empresas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seller-index">
  <div class="block">
    <div class="well text-center">
      <div id="w0" class="action-toolbar btn-toolbar">
        <div id="w1" class="btn-group">
          <?= Html::a('<i class="fa fa-plus"></i> Criar Empresa', ['create'], ['class' => 'btn btn-default']) ?>
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
        'class' => 'with-border',
        'tools' => '',
      ],
    ]); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'name',
                'email:email',
                [
                  'attribute'=>'about',
                  'format'=>'html',
                  'value' => function($data) {
                      return Utils::truncate($data->about, 30) . '...';
                  }
                ],
                'website:url',
                'hours',
                'phone',
                // 'paymentOptions',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

      <?= \machour\yii2\adminlte\widgets\Box::footer(); ?>
    <?= \machour\yii2\adminlte\widgets\Box::end(); ?>

</div>
