<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Buyer */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Buyers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="buyer-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->buyerId], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->buyerId], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'buyerId',
            'userId',
            'pictureId',
            'about',
            'dob',
            'name',
            'gender',
            'email:email',
            'title',
            'website',
            'url_facebook:url',
            'url_googleplus:url',
            'url_flickr:url',
            'url_linkedin:url',
            'url_twitter:url',
            'url_vimeo:url',
            'url_youtube:url',
            'url_instagram:url',
        ],
    ]) ?>

</div>
