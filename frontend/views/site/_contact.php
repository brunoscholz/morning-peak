<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use frontend\models\ContactForm;

$contactModel = new ContactForm();
?>

<section id="contact" class="contact white tab-content">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs text-center" role="tablist">
          <li class="wow rollIn animated" data-wow-duration="1s"><a href="#contact-info" role="tab" data-toggle="tab"><i class="fa fa-paper-plane"></i>
            </a></li>
          <li class="active wow rollIn animated" data-wow-duration="2s"><a href="#contact-form" role="tab" data-toggle="tab"><i class="fa fa-envelope"></i></a></li>
          <li class="wow rollIn animated" data-wow-duration="3s"><a href="#contact-map" class="contact-map" role="tab" data-toggle="tab"><i class="fa fa-map-marker"></i></a></li>
        </ul>            
      </div>
    </div>
  </div>
   <!-- Tab panes -->            
  <div class="tab-content">
    <div class="tab-pane contact-info" id="contact-info">
      <div class="container">
        <div class="row">
        <div class="col-sm-12 text-center">            
          <span class="sub-head">fale conosco</span>
          <div class="title">
            <h2>entre em contato</h2>
          </div>
        </div>
      </div>
        <div class="row text-center">
          <div class="col-sm-4">
            <div class="info-holder">
              <i class="fa fa-taxi"></i>
               <br>
               <p>
                 Av Água Verde, 172 <br>
                 Curitiba <br>
                 PR, Brasil 
               </p>
            </div>                
          </div>
          <div class="col-sm-4">
            <div class="info-holder">
              <i class="fa fa-mobile"></i>
              <br>
              <p>
                (41) 99999-9999
                <br>
              </p>
            </div>                
          </div>
          <div class="col-sm-4">
            <div class="info-holder">
              <i class="fa fa-reply"></i>
              <br>
              <p>
                contato@ondetem-gn.com.br
                <br>
                suporte@ondetem-gn.com.br
              </p>
            </div>                
          </div>
        </div>
      </div>
    </div>
    <div class="tab-pane active contact-info" id="contact-form">
      <div class="container">
        <div class="row">
          <div class="col-sm-12 text-center">            
            <span class="sub-head">fale conosco</span>
            <div class="title">
              <h2>entre em contato</h2>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <?php $form = ActiveForm::begin(['id' => 'contact-form', 'class' => 'form-horizontal']); ?>
              <div class="col-sm-6">
                <div class="form-group">
                  <?= $form->field($contactModel, 'name')->textInput(['autofocus' => true, 'class'=>'form-control', 'placeholder'=>'Seu nome', 'required'=>'required'])->label(false) ?>
                </div>
                <div class="form-group">
                  <?= $form->field($contactModel, 'email')->input('email', ['type'=>'email', 'class'=>'form-control', 'placeholder'=>'Endereço de e-mail', 'required'=>'required'])->label(false) ?>
                </div>
                <div class="form-group">
                  <?= $form->field($contactModel, 'subject')->textInput(['class'=>'form-control', 'placeholder'=>'Assunto', 'required'=>'required'])->label(false) ?>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <?= $form->field($contactModel, 'body')->textarea(['rows' => 3, 'class' => 'form-control btn-block'])->label(false) ?>
                </div>
                <div class="form-group">
                  <?= Html::submitButton('enviar mensagem', ['class' => 'btn btn-block', 'name' => 'contact-button']) ?>
                </div>
              </div>

              <div class="col-sm-12">
                <p class="contact-success">Sua mensagem foi enviada com sucesso!</p>
                <p class="contact-error">Ops! Algo deu errado!</p>
              </div>

            <?php ActiveForm::end(); ?>
          </div>
        </div>
      </div>
    </div>
    <div class="tab-pane contact-info" id="contact-map">
      <div class="container">
        <div class="row">
          <div class="col-sm-12 text-center">            
            <span class="sub-head">fale conosco</span>
            <div class="title">
              <h2>entre em contato</h2>
            </div>
          </div>
        </div>
      </div>
      <div id="map">
        
      </div>
    </div>
  </div>  
</section>