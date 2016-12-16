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
                'description',
                'icon',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

      <?= \machour\yii2\adminlte\widgets\Box::footer(); ?>
        <?= Html::a('Criar Categoria', ['create'], ['class' => 'btn btn-sm btn-success btn-flat pull-right']) ?>
        <?= Html::a('Sugerir Categoria', ['sugest'], ['class' => 'btn btn-sm btn-info btn-flat pull-right']) ?>
    <?= \machour\yii2\adminlte\widgets\Box::end(); ?>

</div>
