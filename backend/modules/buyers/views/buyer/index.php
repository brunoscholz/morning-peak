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

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

      <?= \machour\yii2\adminlte\widgets\Box::footer(); ?>
        <?= Html::a('Criar Empresa', ['create'], ['class' => 'btn btn-sm btn-success btn-flat pull-right']) ?>
    <?= \machour\yii2\adminlte\widgets\Box::end(); ?>
        
</div>
