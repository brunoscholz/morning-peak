<?php

namespace commom\components\widgets;

use yii\base\Widget;

class OfferListView extends Widget
{
	use ListTrait;

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

<div class="ibox-content">
            <div class="table-responsive">
                <table class="table shoping-cart-table">

                    <tbody>
                    <tr>
                        <td width="90">
                            <div class="cart-product-imitation">
                            </div>
                        </td>
                        <td class="desc">
                            <h3>
                                <a href="#" class="text-navy">
                                    Text editor
                                </a>
                            </h3>
                            <p class="small">
                                There are many variations of passages of Lorem Ipsum available
                            </p>
                            <dl class="small m-b-none">
                                <dt>Description lists</dt>
                                <dd>List is perfect for defining terms.</dd>
                            </dl>

                            <div class="m-t-sm">
                                <a href="#" class="text-muted"><i class="fa fa-gift"></i> Add gift package</a>
                                |
                                <a href="#" class="text-muted"><i class="fa fa-trash"></i> Remove item</a>
                            </div>
                        </td>

                        <td>
                            $50,00
                            <s class="small text-muted">$63,00</s>
                        </td>
                        <td width="65">
                            <input type="text" class="form-control" placeholder="2">
                        </td>
                        <td>
                            <h4>
                                $100,00
                            </h4>
                        </td>

                    </tr>
                    </tbody>
                </table>
            </div>

        </div>