<?php

use yii\helpers\Html;
use \machour\yii2\adminlte\widgets\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel backend\models\CategorySearch */

$this->title = 'Categorias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

  <div class="block">
    <div class="well text-center">
      <div id="w0" class="action-toolbar btn-toolbar">
        <div id="w1" class="btn-group">
          <?= Html::a('<i class="fa fa-plus"></i> Criar Categoria', ['create'], ['class' => 'btn btn-default']) ?>
          <?= Html::a('<i class="fa fa-plus"></i> Sugerir Categoria', ['sugest'], ['class' => 'btn btn-default']) ?>
        </div>
      </div>
    </div>
  </div>

    <?= \machour\yii2\adminlte\widgets\Box::begin([
      'type' => 'box-primary',
      'color' => '',
      'noPadding' => false,
      'header' => [
        'title' => $this->title . ' ...',
        'icon' => 'fa-th',
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
                'description',
                'icon',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

      <?= \machour\yii2\adminlte\widgets\Box::footer(); ?>
    <?= \machour\yii2\adminlte\widgets\Box::end(); ?>

</div>
