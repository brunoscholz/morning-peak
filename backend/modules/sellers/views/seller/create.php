<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Seller */

$this->title = 'Criar Empresa';
$this->params['breadcrumbs'][] = ['label' => 'Empresas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seller-create">

    <?= $this->render('_createform', [
        'model' => $model,
    ]) ?>

</div>
