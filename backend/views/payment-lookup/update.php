<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PaymentLookup */

$this->title = 'Update Payment Lookup: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Payment Lookups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->paymentId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="payment-lookup-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
