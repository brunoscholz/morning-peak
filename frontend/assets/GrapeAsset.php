<?php
namespace frontend\assets;

use yii\base\Exception;
use yii\web\AssetBundle;

/**
 * AdminLte AssetBundle
 * @since 0.1
 */
class GrapeAsset extends AssetBundle
{
    public $sourcePath = '@app/themes/grape';
    public $baseUrl = '@web';
    public $css = [
        //'css/font-awesome.min.css',
        'css/animate.css',
        'css/owl.carousel.css',
        'css/owl.theme.css',
        'css/magnific-popup.css',
        'css/style.css',
        'css/responsive.css',
    ];
    public $js = [
        'js/jquery.min.js',
        'js/bootstrap.min.js',
        'js/smoothscroll.js',
        'js/jquery.scrollTo.min.js',
        'js/jquery.localScroll.min.js',
        'js/jquery.nav.js',
        'js/owl.carousel.js',
        'js/jquery.magnific-popup.js',
        'js/jquery.parallax.js',
        'js/jquery.flexslider-min.js',
        'js/jquery.ajaxchimp.min.js',
        'js/matchMedia.js',
        'js/script.js',
        'js/wow.js',
        'js/easing.js',
    ];
    public $depends = [
        'rmrevin\yii\fontawesome\AssetBundle',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    public $publishOptions = [
        'forceCopy'=>true,
    ];
}
