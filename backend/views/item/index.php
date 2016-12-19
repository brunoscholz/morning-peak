<?php

use yii\helpers\Html;
use \machour\yii2\adminlte\widgets\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Itens';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-index">
    <div class="row">
        <div class="col-md-8">
            <?= \machour\yii2\adminlte\widgets\Box::begin([
              'type' => 'box-primary',
              'color' => '',
              'noPadding' => false,
              'header' => [
                'title' => $this->title,
                'icon' => 'fa-shopping-basket',
                'class' => 'with-border',
                'tools' => '{collapse}',
              ],
            ]); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        'title',
                        [
                            'attribute'=>'categoryId',
                            'label'=>'Categoria',
                            'format'=>'html',
                            'value' => function($data) {
                                return $data->category->name;
                            },
                            'filter' => Html::activeDropDownList($searchModel, 'categoryId', ArrayHelper::map(\common\models\Category::find()->where(['<>', 'parentId', 'NULL'])->asArray()->all(), 'categoryId', 'name'),['class'=>'form-control','prompt' => 'Selecione uma categoria']),
                        ],
                        'description',
                        /*[
                            'attribute' => 'keywords',
                            'value' => function ($data) {
                                return empty($data->keywords) ? '-' : $data->keywords;
                            },
                        ],*/

                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
            <?= \machour\yii2\adminlte\widgets\Box::end(); ?>
        </div>
        <div class="col-md-4">
            <?php
                echo $this->render('create', ['model' => new \common\models\Item()]);
            ?>
        </div>
    </div>
</div>
