<?php

use yii\helpers\Html;
use backend\components\Utils;
use \machour\yii2\adminlte\widgets\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="offer-list">
<?php
  $offerChunks = array_chunk($model, 3);
  $rows = ceil((count($model) / 2));

  if($rows > 0)
  {

    for($i = 0; $i < $rows; $i++):
        echo '<div class="row">';
        foreach ($offerChunks[0] as $offer):
?>
          <div class="col-md-4">
            <?= \machour\yii2\adminlte\widgets\BoxSocial::begin([
                'type' => '',
                'color' => 'bg-black',
                'avatar' => Utils::safePicture($offer->seller->picture, 'thumbnail'),
                'username' => $offer->item->category->name,
                'description' => $offer->item->title,
                'cover' => Utils::safePicture($offer->picture, 'cover'),
              ]); ?>
              <?= $offer->isGift ? '<div class="ribbon"><span>BRINDE</span></div>' : '' ?>
              <?= \machour\yii2\adminlte\widgets\BoxSocial::footer(); ?>
                <ul class="products-list product-list-in-box">
                    <li class="item" style="background: unset;">
                      <div class="product-info">
                        <a href="javascript:void(0)" class="product-title"></a>
                            <span class="product-description">
                              <?= $offer->description ?>
                            </span>
                      </div>
                    </li>
                    <!-- /.item -->
                    <li class="item" style="background: unset;">
                      <div class="product-img">
                      </div>
                      <div class="product-info">
                        <a href="javascript:void(0)" class="product-title">Preço
                          <span class="label label-success pull-right"><?= 'R$ ' . number_format($offer->pricePerUnit, 2, ',', '.'); ?></span></a>
                            <span class="product-description">
                              <em>*por unidade</em>
                            </span>
                      </div>
                    </li>
                    <!-- /.item -->
                    <?php
                        if($offer->discountPerUnit != 0):
                            $value = $offer->discountPerUnit . '%';
                    ?>
                    <li class="item" style="background: unset;">
                      <div class="product-img">
                      </div>
                      <div class="product-info">
                        <a href="javascript:void(0)" class="product-title">Desconto
                          <span class="label label-success pull-right"><?= $value ?></span></a>
                            <span class="product-description">
                              <em></em>
                            </span>
                      </div>
                    </li>
                    <?php endif; ?>
                    <!-- /.item -->
                </ul>
                <?= Html::a('Ver Oferta', ['/offer/view', 'id' => $offer->offerId], ['class' => 'btn btn-sm btn-success btn-flat pull-right']) ?>
              <?= \machour\yii2\adminlte\widgets\BoxSocial::end(); ?>
          </div>
  <?php
        endforeach;
        echo '</div><!-- /.row -->';
    endfor;
  } 
  else
  {
  ?>
    <p>Nenhum produto encontrado</p>
  <?php
  }
  ?>
</div>
