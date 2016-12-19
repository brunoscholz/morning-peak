<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Buyer */

$this->title = 'Criar usuário';
$this->params['breadcrumbs'][] = ['label' => 'Usuários', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <?= $this->render('_createform', [
        'model' => $model,
    ]) ?>

</div>