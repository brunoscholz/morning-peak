<?php

use yii\helpers\Html;
use \machour\yii2\adminlte\widgets\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ofertas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="offer-index">

    <?= \machour\yii2\adminlte\widgets\Box::begin([
      'type' => 'box-success',
      'color' => '',
      'noPadding' => false,
      'header' => [
        'title' => 'Ofertas ...',
        'class' => 'with-border',
        'tools' => '{collapse}',
      ],
    ]); ?>
    <?= GridView::widget([
        'id' => 'offer-table',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'itemId',
                'label' => 'Item',
                'value' => function ($data) {
                    return $data->item->title;
                },
            ],
            [
                'attribute'=>'item',
                'label'=>'Categoria',
                'format'=>'html',
                'value' => function($data) {
                    return $data->item->category->name;
                },
                'filter' => Html::activeDropDownList($searchModel, 'item', ArrayHelper::map(\common\models\Category::find()->where(['<>', 'parentId', 'NULL'])->asArray()->all(), 'categoryId', 'name'),['class'=>'form-control','prompt' => 'Selecione uma categoria']),
            ],
            [
                'attribute' => 'sellerId',
                'label' => 'Empresa',
                'value' => function ($data) {
                    return $data->seller->name;
                },
                'filter' => Html::activeDropDownList($searchModel, 'sellerId', ArrayHelper::map(\common\models\Seller::find()->asArray()->all(), 'sellerId', 'name'),['class'=>'form-control','prompt' => 'Selecione uma empresa']),
            ],
            'description',
            [
                'attribute' => 'pricePerUnit',
                'label' => 'Preço',
                'value' => function ($data) {
                    return 'R$ ' . number_format($data->pricePerUnit, 2, ',', '.');
                },
                //'filter' => Html::activeDropDownList($searchModel, 'sellerId', ArrayHelper::map(\common\models\Seller::find()->asArray()->all(), 'sellerId', 'name'),['class'=>'form-control','prompt' => 'Selecione uma empresa']),
                'filter' => ["0"=>"Gratis", "10"=>"até $10", "20"=>"até $20", "50"=>"até $50", "100"=>"até $100", "200"=>"até $200", "201"=>"mais que $200"],
            ],
            [
                'attribute' => 'discountPerUnit',
                'label' => 'Desconto',
                'value' => function ($data) {
                    $value = 'R$ ' . number_format($data->discountPerUnit, 2, ',', '.');
                    return ($data->discountPerUnit == 0) ? '-' : $value;
                },
                'filter' => ["10"=>"até 10%", "20"=>"até 20%", "30"=>"até 30%", "40"=>"até 40%", "50"=>"até 50%", "60"=>"até 60%", "70"=>"até 70%"],
                //'filter' => Html::activeDropDownList($searchModel, 'sellerId', ArrayHelper::map(\common\models\Seller::find()->asArray()->all(), 'sellerId', 'name'),['class'=>'form-control','prompt' => 'Selecione uma empresa']),
            ],
            'keywords:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?= \machour\yii2\adminlte\widgets\Box::footer(); ?>
        <?= Html::a('Criar Oferta', ['create'], ['class' => 'btn btn-sm btn-success btn-flat pull-right']) ?>
    <?= \machour\yii2\adminlte\widgets\Box::end(); ?>

    <p>
        <?= Html::a('Criar Oferta', ['dashboard/notify'], ['class' => 'btn btn-sm btn-success btn-flat pull-right']) ?>
    </p>

</div>
