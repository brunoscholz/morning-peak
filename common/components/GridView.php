<?php

namespace commom\components;

use Yii;
use yii\base\InvalidConfigException;
use yii\bootstrap\ButtonDropdown;
use yii\grid\Column;
use yii\grid\GridView as YiiGridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\web\View;
use yii\widgets\Pjax;

class GridView extends YiiGridView
{
	use BoxTrait;

    public $type = 'table-bordered';

    public $responsive = true;

    public $layout = '{items}
    <div>
        <div class="pull-left">{summary}</div>
        <div class="pull-right">{pager}</div>
        <div style="clear: both;"></div>
    </div>';

    public function init()
    {
        $this->tableOptions = ['class' => 'table ' . $this->type];

        parent::init();
    }

    public function run() {

        if ($this->box) {
            if ($this->responsive) {
                $this->box['body']['class'] = 'table-responsive';
            }
            self::boxBegin($this->box);
        } elseif ($this->responsive) {
            Html::beginTag('div', ['class' => 'table-responsive']);
        }

        parent::run();

        if ($this->box) {
            self::boxEnd();
        } elseif ($this->responsive) {
            Html::endTag('div');
        }

    }
}