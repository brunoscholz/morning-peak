<?php

namespace common\components\widgets;

use yii\base\Widget;
use yii\helpers\Html;

/**
 * Widget for display list of links to related models
 */
class RelatedList extends Widget
{
    /**
     * @var \yii\db\ActiveRecord[] Related models
     */
    public $models = [];

    /**
     * @var string Base to build text content of the link.
     * You should specify attribute name. In case of dynamic generation ('getFullName()') you should specify just 'fullName'.
     */
    public $linkContentBase = 'voucher';

    /**
     * @var string Route to build url to related model
     */
    public $viewRoute;

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (!$this->models) {
            return null;
        }

        $items = [];
        foreach ($this->models as $model) {
            //$items[] = Html::a($model->{$this->linkContentBase}, [$this->viewRoute, 'id' => $model->voucherFactId]);
            $items[] = Html::a($model->voucher->code, [$this->viewRoute, 'id' => $model->voucherFactId]);
        }

        return Html::ul($items, [
            'class' => 'list-unstyled',
            'encode' => false,
        ]);
    }
}