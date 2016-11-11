<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Seller */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Sellers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seller-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->sellerId], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->sellerId], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'sellerId',
            'userId',
            'pictureId',
            'about',
            'name',
            'email:email',
            'website',
            'hours',
            'categories',
            'paymentOptions',
        ],
    ]) ?>

</div>
