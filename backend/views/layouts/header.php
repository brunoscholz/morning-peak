<?php
use yii\helpers\Html;
use yii\helpers\Url;
use backend\components\Utils;
use machour\yii2\notifications\widgets\NotificationsWidget;

/* @var $this \yii\web\View */
/* @var $content string */
//Yii::$app->user->isGuest

$myImages = Url::to('@web/img/');

?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini"><img src="'.$myImages.'logo-icon.png"></span><span class="logo-lg"><img src="'.$myImages.'logo.png"></span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

                <!-- Messages: style can be found in dropdown.less-->
                <?php //NotificationWidget::widget([]); ?>

                <?php if(!Yii::$app->user->isGuest): ?>
                <?= NotificationsWidget::widget([
                    'theme' => NotificationsWidget::THEME_GROWL,
                    'timeAgoLocale' => 'pt-br',
                    'counters' => [
                        '.notifications-header-count',
                        '.notifications-icon-count'
                    ],
                    'listSelector' => '#notifications',
                ]) ?>

                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-warning notifications-icon-count"">0</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header"><span class="notifications-header-count">0</span> novas notificações</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li id="notifications"></li>
                            </ul>
                        </li>
                        <li class="footer"><a href="#">Ver Todas</a></li>
                    </ul>
                </li>

                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?php echo Utils::safePicture(Yii::$app->user->identity->buyer->picture, 'thumbnail'); ?>" class="user-image" alt="User Image"/>
                        <span class="hidden-xs"><?php echo Yii::$app->user->identity->username; ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header" style="background-image: url(<?= Utils::safePicture(Yii::$app->user->identity->buyer->picture, 'cover') ?>);">
                            <img src="<?php echo Utils::safePicture(Yii::$app->user->identity->buyer->picture, 'thumbnail'); ?>" class="img-circle" alt="User Image"/>
                            <p>
                                <small>Membro desde <?php echo Utils::dateToString(Yii::$app->user->identity->createdAt); ?></small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <!-- <div class="col-xs-4 text-center">
                                <a href="#">Seguidores</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Vendas</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Amigos</a>
                            </div> -->
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <?= Html::a(
                                    'Perfil',
                                    ['/buyer/view', 'id' => Yii::$app->user->identity->buyer->buyerId],
                                    ['class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    'Sair',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>

                <!-- User Account: style can be found in dropdown.less -->
                <!-- <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li> -->
            </ul>
        </div>
    </nav>
</header>
