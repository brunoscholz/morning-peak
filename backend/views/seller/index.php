<?php

use yii\helpers\Html;
use \machour\yii2\adminlte\widgets\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel backend\models\SellerSearch */

$this->title = 'Empresas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seller-index">

    <?= \machour\yii2\adminlte\widgets\Box::begin([
      'type' => 'box-primary',
      'color' => '',
      'noPadding' => false,
      'header' => [
        'title' => $this->title . ' ...',
        'class' => 'with-border',
        'tools' => '{collapse}',
      ],
    ]); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'name',
                'email:email',
                'about',
                'website:url',
                'hours',
                'phone',
                // 'paymentOptions',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

      <?= \machour\yii2\adminlte\widgets\Box::footer(); ?>
        <?= Html::a('Criar Empresa', ['create'], ['class' => 'btn btn-sm btn-success btn-flat pull-right']) ?>
    <?= \machour\yii2\adminlte\widgets\Box::end(); ?>

</div>
