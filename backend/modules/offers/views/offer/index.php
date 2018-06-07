<?php

use yii\helpers\Html;
use \machour\yii2\adminlte\widgets\GridView;
use yii\helpers\ArrayHelper;
use common\components\widgets\RelatedList;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ofertas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="offer-index">

    <div class="block">
        <div class="well text-center">
            <div id="w0" class="action-toolbar btn-toolbar">
                <div id="w1" class="btn-group">
                    <?= Html::a('<i class="fa fa-plus"></i> Criar Oferta', ['create'], ['class' => 'btn btn-default']) ?>
                    <?php // Html::a('<i class="fa fa-cog"></i> Settings', ['dashboard/notify'], ['class' => 'btn btn-default']) ?> 
                    <?php //Html::a('Criar Oferta', ['dashboard/notify'], ['class' => 'btn btn-sm btn-success btn-flat pull-right']) ?>
                </div>
            </div>
        </div>
    </div>

    <?= \machour\yii2\adminlte\widgets\Box::begin([
      'type' => 'box-success',
      'color' => '',
      'noPadding' => false,
      'header' => [
        'title' => $this->title . ' ...',
        'class' => 'with-border',
        'tools' => '',
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
            /*[
                'attribute' => 'discountPerUnit',
                'label' => 'Desconto',
                'value' => function ($data) {
                    $value = 'R$ ' . number_format($data->discountPerUnit, 2, ',', '.');
                    return ($data->discountPerUnit == 0) ? '-' : $value;
                },
                'filter' => ["10"=>"até 10%", "20"=>"até 20%", "30"=>"até 30%", "40"=>"até 40%", "50"=>"até 50%", "60"=>"até 60%", "70"=>"até 70%"],
                //'filter' => Html::activeDropDownList($searchModel, 'sellerId', ArrayHelper::map(\common\models\Seller::find()->asArray()->all(), 'sellerId', 'name'),['class'=>'form-control','prompt' => 'Selecione uma empresa']),
            ],*/
            [
                'attribute' => 'voucherFacts',
                'label' => 'Cupons',
                'format' => 'raw',
                'value' => function ($model) {
                    return RelatedList::widget([
                        'models' => $model->voucherFacts,
                        'viewRoute' => '/offer/view',
                    ]);
                },
            ],
            'keywords:ntext', // pill for tags?

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?= \machour\yii2\adminlte\widgets\Box::footer(); ?>
    <?= \machour\yii2\adminlte\widgets\Box::end(); ?>
</div>
