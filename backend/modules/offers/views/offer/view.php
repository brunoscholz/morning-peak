<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use backend\components\Utils;

/* @var $this yii\web\View */
/* @var $model app\models\Offer */

$this->title = 'Ver Oferta';
$this->params['breadcrumbs'][] = ['label' => 'Ofertas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$myImages = Url::to('@web/img/');
$cover = $model->picture->cover;
if (strpos($cover, 'generic-cover') !== false) {
  $cover = $myImages . '/generic-cover.jpg';
}
?>

  <div class="offer-view">
    <div class="invoice" style="margin:0;">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> <?= $this->title ?>
            <small class="pull-right">postada em: <?= Utils::dateToString($model->createdAt) ?></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-xs-4">
            <?= Html::img($cover, ['alt' => 'Item', 'width'=>'100%']) ?>
        </div>
        <!-- /.col -->
        <div class="col-sm-4">
          Postado por:
          <address>
            <strong><?= $model->seller->name ?></strong><br>
            <?= $model->seller->billingAddress->address ?><br>
            <?= $model->seller->billingAddress->city ?> - <?= $model->seller->billingAddress->state ?><br>
            Fone: <?= $model->seller->phone ?><br>
            Email: <?= $model->seller->email ?>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <p class="lead">Preços</p>

          <div class="table-responsive">
            <table class="table">
              <tr>
                <th style="width:50%">Subtotal:</th>
                <td>R$ <?= number_format($model->pricePerUnit, 2, ',', '.') ?></td>
                <td></td>
              </tr>
              <!-- <tr>
                <th>Tax (9.3%)</th>
                <td>$10.34</td>
                <td></td>
              </tr> -->
              <!-- <tr>
                <th>Shipping:</th>
                <td>$5.80</td>
                <td></td>
              </tr> -->
              <tr>
                <th>Desconto:</th>
                <?php $totalDiscount = ($model->pricePerUnit * $model->discountPerUnit/100); ?>
                <td><?= ($totalDiscount == 0) ? '-' : 'R$ ' . number_format($totalDiscount, 2, ',', '.') ?></td>
                <td></td>
              </tr>
              <tr>
                <th>Total:</th>
                <?php $totalPrice = $model->pricePerUnit - $totalDiscount; ?>
                <td>R$ <?= number_format($totalPrice, 2, ',', '.') ?></td>
                <td>COIN 3000</td>
              </tr>
            </table>
          </div>
        </div>
        <!-- /.col -->

      </div>
      <!-- /.row -->

      <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-4">
          <p class="lead">Descrição</p>
          <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
            <?= $model->description ?>
          </p>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <p class="lead">Tags</p>

          <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
            <?= $model->keywords ?>
          </p>
        </div>
        <!-- accepted payments column -->
        <div class="col-xs-4">
          <p class="lead">Opções de Pagamento:</p>
          <?php
            $query = \common\models\PaymentLookup::find();
            $pays = explode(',', $model->seller->paymentOptions);
            foreach ($pays as $payop):
                $query->orWhere(['like binary', 'paymentId', $payop]);
            endforeach;
            $dataCategory=ArrayHelper::map($query->asArray()->all(), 'name', 'icon');
          
            $pays = explode(',', $model->seller->paymentOptions);
            foreach ($dataCategory as $key => $value):
                //Html::img($model->picture->cover, ['alt' => 'Item', 'width'=>'100%'])
                echo '<img src="data:image/gif;base64,' . $value . '" alt="'.$key.'" title="'.$key.'" width="51" height="32"/>';
            endforeach;
          ?>

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12">
          <?= Html::a('Editar', ['update', 'id' => $model->offerId], ['class' => 'btn btn-primary pull-right']) ?>

          <?= Html::a('Excluir', ['delete', 'id' => $model->offerId], [
            'class' => 'btn btn-danger pull-right',
            'data' => [
                'confirm' => 'Tem certeza que deseja excluir essa oferta?',
                'method' => 'post',
            ],
          ]) ?>
        </div>
      </div>
    </div>
</div>
