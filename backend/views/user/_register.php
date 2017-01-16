<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */

$myImages = Url::to('@web/img/');
/*$thumb = $myImages . '/generic-avatar.png';
$cover = $myImages . '/generic-cover.jpg';*/

$thumb = $model->picture->thumbnail;
$cover = $model->picture->cover;

?>

<div class="register-form">

    <?php
        $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);
    ?>

    <?php $wizard_config = [
        'id' => 'stepwizard',
        'steps' => [
            1 => [
                'title' => 'Perfil Usuário',
                'icon' => 'fa fa-user',
                'content' => $this->render('_step3', [
                                'model' => $model,
                                'form' => $form,
                            ]),
                //'skippable' => true,
                'buttons' => [
                    'next' => [
                        'title' => 'Próximo', 
                        'options' => [
                            'class' => 'btn btn-primary'
                        ],
                     ],
                 ],
            ],
            2 => [
                'title' => 'Perfil Empresa',
                'icon' => 'fa fa-building',
                'content' => $this->render('_step1', [
                                'model' => $model,
                                'form' => $form,
                            ]),
                //'skippable' => true,
                'buttons' => [
                    'prev' => [
                        'title' => 'Anterior',
                        'options' => [
                            'class' => 'btn btn-danger'
                        ],
                     ],
                     'next' => [
                        'title' => 'Próximo', 
                        'options' => [
                            'class' => 'btn btn-primary'
                        ],
                     ],
                 ],
            ],
            3 => [
                'title' => 'Fotos Empresa',
                'icon' => 'fa fa-camera',
                'content' => $this->render('_step2', [
                                'model' => $model,
                                'form' => $form,
                            ]),
                'buttons' => [
                    'prev' => [
                        'title' => 'Anterior',
                        'options' => [
                            'class' => 'btn btn-danger'
                        ],
                     ],
                    'save' => [
                        'title' => 'Salvar',
                        'options' => [
                            'class' => 'btn btn-primary',
                            'type' => 'submit'
                        ],
                    ],
                 ],
            ],
        ],
        'complete_content' => $this->render('_stepFinal', [
                                'model' => array(),
                            ]), // Optional final screen
        'start_step' => 1, // Optional, start with a specific step
    ];
    ?>

    <?= \drsdre\wizardwidget\WizardWidget::widget($wizard_config); ?>

    <?php ActiveForm::end(); ?>

</div>

<?php
//The AJAX request for the Add Another button. It updates the #div-address-form div.
/*$script = <<< JS
JS;
$position = \yii\web\View::POS_READY;
$this->registerJs($script, $position);*/