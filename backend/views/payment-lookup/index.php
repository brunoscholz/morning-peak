<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payment Lookups';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-lookup-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Payment Lookup', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'paymentId',
            'name',
            'type',
            //'icon',
                [
                    'attribute'=>'icon',
                    'label'=>'Icon',
                    'format'=>'html',
                    'content' => function($data) {
                        //var_dump($data);
                        $url = 'data:image/gif;base64,' . $data->icon;
                        return Html::img($url, ['alt'=>'yii']);
                    }
                ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
