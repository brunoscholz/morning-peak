<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sellers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seller-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Seller', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'sellerId',
            'userId',
            'about',
            'name',
            'email:email',
            // 'website',
            // 'hours',
            'categories',
            // 'paymentOptions',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
