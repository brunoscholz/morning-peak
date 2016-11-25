<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ReviewFact */

$this->title = 'Update Review Fact: ' . $model->reviewFactId;
$this->params['breadcrumbs'][] = ['label' => 'Review Facts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->reviewFactId, 'url' => ['view', 'id' => $model->reviewFactId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="review-fact-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
