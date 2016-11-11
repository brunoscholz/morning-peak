<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\GrapeAsset;

$bundle = GrapeAsset::register($this);

$this->title = 'OndeTem?!';
?>
    <!-- header start -->
    <?= $this->render('_header', [
        'baseUrl' => $bundle->baseUrl,
    ]) ?>
    <!-- header end -->

    <!-- banner start -->
    <?= $this->render('_banner', [
        'baseUrl' => $bundle->baseUrl,
    ]) ?>
    <!-- banner end -->

    <!-- intro start -->
    <?= $this->render('_intro', [
        'baseUrl' => $bundle->baseUrl,
    ]) ?>
    <!-- intro end -->

    <!-- feature start -->
    <?= $this->render('_feature', [
        'baseUrl' => $bundle->baseUrl,
    ]) ?>
    <!-- feature end -->

    <!-- description start -->
    <?= $this->render('_description', [
        'baseUrl' => $bundle->baseUrl,
    ]) ?>
    <!-- description end-->

    <!-- video start -->
    <?= $this->render('_video', [
        'baseUrl' => $bundle->baseUrl,
    ]) ?>
    <!-- video end -->

    <!-- screenshot start -->
    <?= $this->render('_screenshot', [
        'baseUrl' => $bundle->baseUrl,
    ]) ?>
    <!-- screenshot end -->

    <!-- review start -->
    <?= $this->render('_review', [
        'baseUrl' => $bundle->baseUrl,
    ]) ?>
    <!-- review end -->

    <!-- price start -->
    <?= $this->render('_price', [
        'baseUrl' => $bundle->baseUrl,
    ]) ?>
    <!-- price end -->

    <!-- download start -->
    <?= $this->render('_download', [
        'baseUrl' => $bundle->baseUrl,
    ]) ?>
    <!-- download end -->

    <!-- support start -->
    <?= $this->render('_support', [
        'baseUrl' => $bundle->baseUrl,
    ]) ?>
    <!-- support end -->

    <!-- subscription start -->
    <?= $this->render('_subscription', [
        'baseUrl' => $bundle->baseUrl,
    ]) ?>
    <!-- subscription end -->

    <!-- contact start -->
    <?= $this->render('_contact', [
        'baseUrl' => $bundle->baseUrl,
    ]) ?>
    <!-- contact end -->

    <!-- footer start -->
    <?= $this->render('_footer', [
        'baseUrl' => $bundle->baseUrl,
    ]) ?>
    <!-- footer end -->
