<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Offer */

$this->title = 'Modificar Oferta';
$this->params['breadcrumbs'][] = ['label' => 'Ofertas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Oferta', 'url' => ['view', 'id' => $model->offerId]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="offer-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
