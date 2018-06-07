<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Buyer */

$this->title = 'Criar Usuário';
$this->params['breadcrumbs'][] = ['label' => 'Usuários', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="buyer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'picture' => $picture,
    ]) ?>

</div>
