<?php

namespace common\components\widgets;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

trait ListTrait {

    public $box = false;

    public static $listConfig = [];

    private static $defaultConfig = [
        'type' => 'box-widget',
        'color' => '',
        'noPadding' => false,
        'header' => [
            'title' => 'offers',
            'class' => '',
            'label-tool' => '',
            'tools' => '',
            'icon' => 'fa-building',
        ],
        'body' => [
            'class' => '',
            'bg-image' => '',
        ],
        'footer' => '',
    ];

    public static function listBegin($listConfig = []) {

        self::$listConfig = ArrayHelper::merge(self::$defaultConfig, $listConfig);

        //echo Html::beginTag('div', ['class' => 'box-simple box-default']);
        echo Html::beginTag('div', ['class' => 'box ' . self::$listConfig['type'] . ' ' . self::$listConfig['color']]);

        $class = 'box-body table-responsive ';
        $class .= self::$listConfig['body']['class'];
        $style = '';
        if (self::$listConfig['noPadding']) {
            $class .= ' no-padding';
        }

        echo Html::beginTag('div', ['class' => $class, 'style' => $style]);
        $header = self::$listConfig['header'];
        if (!empty($header['title'])) {
            echo Html::beginTag('h4', ['class' => '', 'style'=>"background-color:#f7f7f7; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;"]);
            if (!empty($header['icon'])) {
                echo Html::tag('i', null, ['class' => 'fa ' . $header['icon']]);
            }
            echo Html::encode(' ' . $header['title']);
            echo Html::endTag('h4');
        }
    }

    static $footerUsed = false;
    public static function footer() {
        self::$footerUsed = true;
        echo Html::endTag('div');
        echo Html::beginTag('div', ['class' => 'box-footer']);
        if (!empty(self::$listConfig['footer'])) {
            echo self::$listConfig['footer'];
            echo Html::endTag('div');
        }
    }

    public static function listEnd() {
        if (!self::$footerUsed) {
            echo Html::endTag('div');
            if (!empty(self::$listConfig['footer'])) {
                echo Html::beginTag('div', ['class' => 'box-footer']);
                echo self::$listConfig['footer'];
                echo Html::endTag('div');
            }
        } elseif (empty(self::$listConfig['footer'])) {
            echo Html::endTag('div');
        }
        echo Html::endTag('div');
    }

    private static function boxTool($widget, $icon) {
        $col = 'white';
        if (empty(self::$listConfig['color']))
            $col = 'black';

        return Html::tag(
            'button',
            Html::tag('i', null, ['class' => 'fa fa-' . $icon]),
            ['data-widget' => $widget, 'class' => 'btn btn-box-tool', 'style' => 'color: ' . $col . ';']
        );
    }

}