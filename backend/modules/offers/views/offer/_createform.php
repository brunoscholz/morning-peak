<?php

use common\models\Item;
use backend\models\ItemSearch;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\ArrayHelper;
use yii\jui\AutoComplete;
use yii\web\JsExpression;


/* @var $this yii\web\View */
/* @var $model app\models\Offer */
/* @var $form yii\widgets\ActiveForm */
$myImages = Url::to('@web/img/');
$cover = $myImages . '/generic-cover.jpg';
?>

<div class="offer-form">

    <?php
        $form = ActiveForm::begin(['action' => ['offer/create'], 'options' => ['enctype' => 'multipart/form-data']]);
        echo Html::activeHiddenInput($model, 'sellerId', ['value' => $seller->sellerId]);
    ?>

    <?php $wizard_config = [
        'id' => 'stepwizard',
        'steps' => [
            1 => [
                'title' => 'Cadastrar Oferta',
                'icon' => 'fa fa-plus',
                'content' => $this->render('_step1', [
                                'model' => $model,
                                'form' => $form,
                            ]),
                //'skippable' => true,
                'buttons' => [
                    'next' => [
                        'title' => 'Próximo', 
                        'options' => [
                            'class' => 'center btn btn-primary'
                        ],
                     ],
                 ],
            ],
            2 => [
                'title' => 'Item',
                'icon' => 'fa fa-archive',
                'content' => $this->render('_step2', [
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
                'title' => 'Detalhes da Oferta',
                'icon' => 'fa fa-gift',
                'content' => $this->render('_step3', [
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
            4 => [
                'title' => 'Foto',
                'icon' => 'fa fa-camera',
                'content' => $this->render('_step4', [
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
        'complete_content' => $this->render('_step1', [
            'model' => array(),
        ]), // Optional final screen
        'start_step' => 1, // Optional, start with a specific step
    ];
    ?>

    <?= \drsdre\wizardwidget\WizardWidget::widget($wizard_config); ?>

    <?php ActiveForm::end(); ?>

</div>
