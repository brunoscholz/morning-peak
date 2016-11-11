<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use frontend\assets\GrapeAsset;

$bundle = GrapeAsset::register($this);

/**
 * @var $this \yii\base\View
 * @var $content string
 */
?>
<?php $this->beginPage(); ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
  <meta charset="<?= Yii::$app->charset ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?= Html::csrfMetaTags() ?>
  <title><?= Html::encode($this->title) ?></title>
  <?php $this->head() ?>

	<meta name="description" content="" />
	<meta name="keywords" content="" />
  <meta name="robots" content="all">

  <!-- Added google font -->
  <link href='http://fonts.googleapis.com/css?family=Dosis:400,600,700,800' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>

<!--Fav and touch icons-->
  <link rel="shortcut icon" href="<?php echo $bundle->baseUrl ?>/images/icons/favicon.ico">
  <link rel="apple-touch-icon" href="<?php echo $bundle->baseUrl ?>/images/icons/apple-touch-icon.png">
  <link rel="apple-touch-icon" sizes="72x72" href="<?php echo $bundle->baseUrl ?>/images/icons/apple-touch-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="114x114" href="<?php echo $bundle->baseUrl ?>/images/icons/apple-touch-icon-114x114.png">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
  <![endif]-->
</head>

<body>
	<?php $this->beginBody() ?>

	<!-- Preloader -->
  <div id="faceoff">
    <div id="preloader"></div>
    <div class="preloader-section"></div>
  </div>
  <!-- Preloader end -->

  <?= $content ?>

  <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>

	<?php $this->endBody(); ?>
</body>
</html>

<?php $this->endPage(); ?>
