<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model backend\models\Buyer */
/* @var $form yii\widgets\ActiveForm */

$thumb = $picture->thumbnail;
?>

<div class="buyer-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($picture, 'imageCover')->fileInput() ?>

    <div class="form-group kv-avatar center-block" style="width:280px">
        <?= $form->field($picture, 'imageThumb')->widget(FileInput::classname(), [
            'pluginOptions' => [
                'resizeImages' => true,
                //'initialPreview' => "<img src='$thumb' class='file-preview-image' alt='Avatar' title='Avatar'>",
                'overwriteInitial' => true,
                'maxFileSize' => 1500,
                'showClose' => false,
                'showCaption' => false,
                'showBrowse' => false,
                'browseOnZoneClick' => true,
                'browseLabel' => '',
                'removeLabel' => '',
                'removeIcon' => '<i class="glyphicon glyphicon-remove"></i>',
                'removeTitle' => 'Cancelar',
                'elErrorContainer' => '#kv-avatar-errors-2',
                'msgErrorClass' => 'alert alert-block alert-danger',
                'defaultPreviewContent' => "<img src='$thumb' alt='Avatar' style='width:160px'><h6 class='text-muted'>Click to select</h6>",
                //'layoutTemplates' => "{main2: '{preview} ' +  btnCust + ' {remove} {browse}'}",
                'layoutTemplates' => [
                    'main2' => '{preview}<div class="kv-upload-progress hide"></div>{remove}{browse}',
                ],
                'allowedFileExtensions' => ["jpg", "png", "gif"],
                'maxImageWidth' => 400,
                'maxImageHeight' => 400,
            ],
            'options' => ['accept' => 'image/*'],
        ]); ?>
    </div>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dob')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'about')->textInput(['maxlength' => true]) ?>

    <?php
        $dataGender = array('mas' => 'Masculino', 'fem' => 'Feminino', 'oth' => 'Outro');
        //ArrayHelper::map(\backend\models\Category::find()->where(['<>', 'categoryId', '0'])->asArray()->all(), 'categoryId', 'name');
    ?>

    <?= $form->field($model, 'gender')->dropDownList(
        $dataGender,
        ['prompt'=>' - Selecione seu gênero - ']
    ) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'website')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
//The AJAX request for the Add Another button. It updates the #div-address-form div.
/*$script = <<< JS
JS;
$position = \yii\web\View::POS_READY;
$this->registerJs($script, $position);*/