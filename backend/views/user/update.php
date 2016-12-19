<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Buyer */

$this->title = 'Modificar usuário';
$this->params['breadcrumbs'][] = ['label' => 'Usuários', 'url' => ['/buyer/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>