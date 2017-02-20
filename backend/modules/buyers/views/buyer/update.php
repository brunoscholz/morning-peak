<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Buyer */

$this->title = 'Update Buyer: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Buyers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->buyerId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="buyer-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
