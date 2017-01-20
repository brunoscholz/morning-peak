<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use backend\components\Utils;
use frontend\assets\GrapeAsset;
use frontend\assets\AppAsset;

/* @var $this yii\web\View */

$bundle = GrapeAsset::register($this);
$mybundle = AppAsset::register($this);
$this->title = 'Oferta - ' . $model->item->title;

$myImages = Url::to('@web/img/');
$cover = $model->picture->cover;
if (strpos($cover, 'generic-cover') !== false) {
  $cover = $myImages . '/generic-cover.jpg';
}
?>
<header class="alt-navbar-fixed-top">
  <nav class="navbar navbar-default" role="navigation">
    <div class="container">
      <div class="row">
        <div class="col-sm-3">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <h1><a class="nav-brand large-logo" href="http://www.ondetem-gn.com.br"> <img src="<?php echo $myImages ?>logo.png" alt="ondetem?!"></a></h1>
          </div>
        </div>
        <div class="col-sm-7">
          <!-- Collect the nav toggling -->
          <div class="collapse navbar-collapse navbar-example" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
              
            </ul>
          </div><!-- /.navbar-collapse -->
        </div>
        <div class="col-sm-2 mob-right">
          <ul class="app pull-right">
            <!-- <li><a href=""><i class="fa fa-apple"></i></a></li> -->
            <li><a href="https://play.google.com/store/apps/details?id=com.ionicframework.appv2355299"><i class="fa fa-android"></i></a></li>
            <!-- <li><a href=""><i class="fa fa-windows"></i></a></li> -->
          </ul>
        </div>
      </div>
    </div><!-- /.container -->
  </nav>
</header>

<section id="published-story" class="offerview-section white">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 text-center">
        <span class="sub-head wow fadeInLeft">oferta</span>
        <div class="title wow fadeInRight">
          <h2><?= $model->item->title ?></h2>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6 col-sm-push-2 wow bounceInUp" data-wow-duration="2s">
        <div class="support-block active">
          <span class="support-icon"><i class="fa fa-heart"></i></span>
          <?= Html::img($cover, ['alt' => 'Item', 'width'=>'100%']) ?>
          <div class="support-description">
            <ul>
              <li><?= $model->description ?></li>
              <li>
                <span class="price">R$ <?= number_format($model->pricePerUnit, 2, ',', '.') ?></span>
                <?php $totalDiscount = ($model->pricePerUnit * $model->discountPerUnit/100); ?>
                <span class="month"><?= ($totalDiscount == 0) ? '' : '(- R$ ' . number_format($totalDiscount, 2, ',', '.') . ' off)' ?></span>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-sm-push-2 wow bounceInUp" data-wow-duration="3s">
        <div class="support-block">
          <span class="support-icon"><i class="fa fa-industry"></i></span>
          <h3><?= $model->seller->name ?></h3>
          <p><?= $model->seller->about ?></p>
          <div class="support-description">
            <ul>
              <li><?= $model->seller->billingAddress->address ?>, <?= $model->seller->billingAddress->city ?> - <?= $model->seller->billingAddress->state ?></li>
              <li>Fone: <?= $model->seller->phone ?></li>
              <li>
                <?php if(!empty($model->seller->website)): ?>
                Mais informações:<br>
                <?= Html::a($model->seller->website,  null, ['href' => 'http://'.$model->seller->website, 'class' => 'btn']) ?><br>
                ou<br>
                <?php endif; ?>
                <?= Html::a($model->seller->email,  null, ['href' => $model->seller->email, 'class' => 'btn']) ?>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="download" class="downlaod">
  <div class="trans-bg">
    <div class="container">
      <div class="row">
        <div class="col-sm-12 text-center">
          <span class="sub-head wow fadeInLeft" style="color:#fff;">ainda não tem o app Onde tem?</span>
          <h2 class="wow swing">faça o download!</h2>
          <p>Em breve, outras plataformas</p>
          <!-- <div class="wow fadeInLeft" style="display:inline-block"><a href="" class="btn"><i class="fa fa-apple"></i> app store</a><div class="under-construction">&nbsp;</div></div> -->
          <div class="wow fadeInLeft" style="display:inline-block"><a href="https://play.google.com/store/apps/details?id=com.ionicframework.appv2355299" class="btn"><i class="fa fa-android"></i> play store</a></div>
          <!-- <div class="wow fadeInLeft" style="display:inline-block"><a href="" class="btn"><i class="fa fa-windows"></i> windows</a><div class="under-construction">&nbsp;</div></div> -->
        </div>
      </div>
    </div>
  </div> <!-- /.trans-bg -->  
</section>

