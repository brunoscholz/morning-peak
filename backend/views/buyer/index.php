<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Buyers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="buyer-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Buyer', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'buyerId',
            'userId',
            'about',
            'dob',
            'name',
            // 'lastname',
            // 'gender',
            // 'email:email',
            // 'title',
            // 'website',
            // 'url_facebook:url',
            // 'url_googleplus:url',
            // 'url_flickr:url',
            // 'url_linkedin:url',
            // 'url_twitter:url',
            // 'url_vimeo:url',
            // 'url_youtube:url',
            // 'url_instagram:url',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
