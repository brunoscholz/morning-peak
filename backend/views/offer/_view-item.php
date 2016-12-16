<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Item */
?>

<div class="item-view" style="display: none;">

    <div class="small-box bg-aqua">
        <div class="inner item-result">
            
        </div>
        <div class="icon">
            <i class="fa fa-shopping-cart"></i>
        </div>
        <?= Html::a('Remover Item <i class="fa fa-arrow-circle-right"></i>', FALSE, ['class'=>'unload-item-view small-box-footer']) ?>
    </div>
</div>
