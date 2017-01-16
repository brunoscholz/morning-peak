<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<section id="subscription" class="subscription">
  <div class="trans-bg">
    <div class="container">
      <div class="row">
        <div class="col-sm-6 col-sm-offset-3 text-center">
        <h2 class="wow swing">inscreva-se na nossa newsletter</h2>
        <div class="newsletter-form">
          <?php $form = ActiveForm::begin(['action'=>'site/newsletter', 'class'=>'newsletter-signup']); ?>
            <?php if(Yii::$app->session->hasFlash('newsletterSuccess')): ?>
              <p class="newsletter-success">
                <?= Yii::$app->session->getFlash('newsletterSuccess') ?>
              </p>
            <?php endif; ?>
            <?php if(Yii::$app->session->hasFlash('newsletterError')): ?>
              <p class="newsletter-error">
                <?= Yii::$app->session->getFlash('newsletterError') ?>
              </p>
            <?php endif; ?>
            <div class="input-group">
              <?= Html::input('email', 'email', null, ['placeholder'=>'Digite seu e-mail', 'class'=>'form-control wow fadeInLeft']) ?>
              <span class="input-group-btn wow fadeInRight">
              <?= Html::submitButton('Inscrever', ['class' => 'btn btn-sub']) ?>
              </span>
            </div><!-- /.input-group -->
          <?php ActiveForm::end(); ?>
        </div>
        </div>
      </div>
    </div>
  </div> <!-- /.trans-bg --> 
</section>