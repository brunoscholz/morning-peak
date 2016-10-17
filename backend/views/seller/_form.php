<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Seller */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="seller-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'about')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'website')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'facebookSocialId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'twitterSocialId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'instagramSocialId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'snapchatSocialId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'linkedinSocialId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'githubSocialId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url_youtube')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hours')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'categories')->textInput(['maxlength' => true]) ?>

    <!-- $form->field($model, 'paymentOptions')->textInput(['maxlength' => true]) -->

    <?php $dataCategory=ArrayHelper::map(\app\models\PaymentLookup::find()->asArray()->all(), 'name', 'icon', 'paymentId'); ?>

    <?php
        $list = [];
        foreach ($dataCategory as $key => $value)
        {
            foreach ($value as $k => $v)
            {
                $tmp = '<img src="data:image/gif;base64,' . $v . '" alt="'.$k.'" title="'.$k.'" width="51" height="32"/>';
                $list[$key] = $tmp;
            }
        }
    ?>
    

    <?= $form->field($model, 'paymentOptions')->checkboxList($list, ['encode'=> false]) ?>

    <?= $form->field($model, 'userId')->hiddenInput()->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
