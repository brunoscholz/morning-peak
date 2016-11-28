<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\BaseMessage instance of newly created mail message */

?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>OndeTem?</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="https://fonts.googleapis.com/css?family=Lato:400,900" rel="stylesheet" type='text/css'>
<style type="text/css">body{color: #34b483;}.social{display: table;margin: 0 auto;}.social ul{padding: 0px;margin: 16px 0 0 0;text-align:center;}.social ul li{display: inline;}.social ul li a{display: inline-block;margin: 5px;text-align: center;}.social img{width: 35px;}.newsletter{background-color: rgba(0, 0, 0, 0.8);padding: 25px 0;max-width: 800px;margin: 0 auto;border-radius: 20px 20px;text-align: center;box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12);}h1 {font-size: 38px;line-height: 52px;font-style: normal;font-weight: 900;font-family: "Lato";letter-spacing: 2.5px;margin: 0 auto;position: relative;text-align: center;}h2{font-size: 30px;line-height: 36px;font-weight: 400;font-style: normal;font-family: "Poiret One", cursive;margin: 0 auto;position: relative;text-align: center;}.banner{margin-top: 20px;background-image: url("http://ondetem.tk/mail/polygon-back.png");padding: 40px 0;background-size: cover;}.banner h1{color: #f3f2f3;text-transform: none;}.content{padding: 40px 0;max-width: 400px;margin: 0 auto;text-align: center;font-weight: 400;font-size: 24px;}.disclaimer{font-weight: 400;font-size: 16px;color: #777;}.copyright{font-weight: 600;font-size: 18px;}.logo svg {height: 175px; fill: #34b483;}h1.logo{overflow: hidden;text-align: center;}h1.logo:before,h1.logo:after {background-color: #34b483;content: "";display: inline-block;height: 5px;position: relative;vertical-align: middle;width: 50%;}h1.logo:before {right: 0.5em;margin-left: -50%;}h1.logo:after {left: 0.5em;margin-right: -50%;}</style>
</head>
<body>
    <?php $this->beginBody() ?>
    <section class="newsletter">
        <div class="container">
            <div class="row">
                <div class="col s12 logo">
                    <svg version="1.1" id="Layer_1" xmlns:figma="http://www.figma.com/figma/ns"
                     xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 47 57"
                     style="enable-background:new 0 0 47 57;" xml:space="preserve">
                        <g>
                            <path d="M23.5,0.7c13.2,0,23.6,10.8,23,24c-0.2,5.3-2.3,9.9-5.1,14.3c-3.4,5.1-7.5,9.5-12.2,13.5c-1.3,1.1-2.7,2.2-4.1,3.3
                                c-1.1,0.9-2.1,0.9-3.2,0.1c-7.4-6-14.2-12.4-18.5-21c-3-5.8-3.9-11.9-1.8-18.2C4.6,7.1,13.4,0.7,23.5,0.7z M41.9,23.6
                                c0-9.3-7-17-16.5-18.1C16.2,4.3,7.3,10.9,5.5,20c-1.1,5.6,0.6,10.6,3.4,15.3c3.6,5.9,8.5,10.7,13.8,15.2c0.5,0.5,1,0.5,1.5,0
                                c1.8-1.7,3.7-3.2,5.4-4.9c3.5-3.4,6.7-7.1,9.1-11.4C40.6,30.8,41.9,27.4,41.9,23.6z"/>
                            <path d="M30.5,35c-1.9,0.6-3.5,1.3-5.1,1.6c-5.6,1-10.6-1.9-13-7.4c-1.9-4.3-0.4-10.5,3.4-13.5c4.3-3.5,10.4-3.8,14.8-0.6
                                c4.7,3.4,6.3,9.9,3.6,15.2c-0.5,1-0.4,1.6,0.4,2.3c1.5,1.4,1.1,3.3-0.6,4.1c-1,0.5-1.8,0-2.5-0.6C31,35.8,30.7,35.3,30.5,35z
                                 M23.5,17.6c-4.1,0-7.2,3.1-7.2,7.2c0,4.2,3.1,7.3,7.2,7.3s7.2-3.2,7.2-7.3S27.6,17.6,23.5,17.6z"/>
                            <path d="M28.9,24.7c-0.2,0.2-0.6,0.8-0.9,0.8c-0.4,0-1.1-0.6-1.2-1c-0.2-1.7-1.2-2.5-2.8-3c-0.4-0.1-0.6-0.8-0.9-1.3
                                c0.5-0.3,0.9-0.8,1.4-0.8C26.8,19.5,28.9,21.8,28.9,24.7z"/>
                        </g>
                    </svg>
                </div>
                <div class="col s12">
                    <h1 class="logo">OndeTem?</h1>
                </div>
                <div class="col s12">
                    <h2>Guia de Negócios</h2>
                </div>
            </div>
            <div class="row banner">
                <div class="col s12">
                    <h1 class="title">Olá, <?= Html::encode($user['name']) ?></h1>
                </div>
            </div>
            <div class="row content">
                <div class="col s12">
                    <div class="col s6">
                        <?= $data['message'] ?>
                    </div>
                </div>
            </div>
            <div class="contact">
                <div class="row">
                    <div class="col s12 disclaimer">
                        <p><?= $data['disclaimer'] ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <div class="col s12 social">
                            <ul>
                              <li><a href="https://www.facebook.com/ondetemnegocios/" class="btn-luxore btn-large" target="_blank"><img src="http://ondetem.tk/mail/facebook.png"></i></a></li>
                              <li><a href="https://twitter.com/ondetemnegocios" class="btn-luxore btn-large" target="_blank"><img src="http://ondetem.tk/mail/twitter.png"></i></a></li>
                              <li><a href="https://www.instagram.com/ondetemnegocios/" class="btn-luxore btn-large" target="_blank"><img src="http://ondetem.tk/mail/instagram.png"></i></a></li>
                            </ul>
                          </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 copyright">
                        OndeTem? <?php echo date('Y'); ?>
                    </div>
                </div>
            </div>
        </div>  
    </section>
    <?php $this->endBody() ?>
</body></html>
<?php $this->endPage() ?>
