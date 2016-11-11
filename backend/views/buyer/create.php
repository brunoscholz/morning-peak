<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Buyer */

$this->title = 'Create Buyer';
$this->params['breadcrumbs'][] = ['label' => 'Buyers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="buyer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
