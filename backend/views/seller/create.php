<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Seller */

$this->title = 'Criar Empresas';
$this->params['breadcrumbs'][] = ['label' => 'Empresas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="seller-create">

    <h1><?= Html::encode($this->title) ?></h1>

	

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
