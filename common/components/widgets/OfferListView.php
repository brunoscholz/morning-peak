<?php

namespace common\components\widgets;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\base\Widget;
use yii\widgets\LinkPager;
use backend\components\Utils;

class OfferListView extends Widget
{
	use ListTrait;

    public $type = 'table-bordered';

    public $responsive = true;

    /*public $layout = '{items}
    <div>
        <div class="pull-left">{summary}</div>
        <div class="pull-right">{pager}</div>
        <div style="clear: both;"></div>
    </div>';*/

     /**
     * @var array the HTML attributes for the container tag of the list view.
     * The "tag" element specifies the tag name of the container element and defaults to "div".
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];
    /**
     * @var \yii\data\DataProviderInterface the data provider for the view. This property is required.
     */
    public $dataProvider;
    /**
     * @var array the configuration for the pager widget. By default, [[LinkPager]] will be
     * used to render the pager. You can use a different widget class by configuring the "class" element.
     * Note that the widget must support the `pagination` property which will be populated with the
     * [[\yii\data\BaseDataProvider::pagination|pagination]] value of the [[dataProvider]].
     */
    public $pager = [];
    /**
     * @var array the configuration for the sorter widget. By default, [[LinkSorter]] will be
     * used to render the sorter. You can use a different widget class by configuring the "class" element.
     * Note that the widget must support the `sort` property which will be populated with the
     * [[\yii\data\BaseDataProvider::sort|sort]] value of the [[dataProvider]].
     */
    public $sorter = [];
    /**
     * @var string the HTML content to be displayed as the summary of the list view.
     * If you do not want to show the summary, you may set it with an empty string.
     *
     * The following tokens will be replaced with the corresponding values:
     *
     * - `{begin}`: the starting row number (1-based) currently being displayed
     * - `{end}`: the ending row number (1-based) currently being displayed
     * - `{count}`: the number of rows currently being displayed
     * - `{totalCount}`: the total number of rows available
     * - `{page}`: the page number (1-based) current being displayed
     * - `{pageCount}`: the number of pages available
     */
    public $summary;
    /**
     * @var array the HTML attributes for the summary of the list view.
     * The "tag" element specifies the tag name of the summary element and defaults to "div".
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $summaryOptions = ['class' => 'summary'];
    /**
     * @var bool whether to show an empty list view if [[dataProvider]] returns no data.
     * The default value is false which displays an element according to the `emptyText`
     * and `emptyTextOptions` properties.
     */
    public $showOnEmpty = false;
    /**
     * @var string the HTML content to be displayed when [[dataProvider]] does not have any data.
     */
    public $emptyText;
    /**
     * @var array the HTML attributes for the emptyText of the list view.
     * The "tag" element specifies the tag name of the emptyText element and defaults to "div".
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $emptyTextOptions = ['class' => 'empty'];
    /**
     * @var string the layout that determines how different sections of the list view should be organized.
     * The following tokens will be replaced with the corresponding section contents:
     *
     * - `{summary}`: the summary section. See [[renderSummary()]].
     * - `{items}`: the list items. See [[renderItems()]].
     * - `{sorter}`: the sorter. See [[renderSorter()]].
     * - `{pager}`: the pager. See [[renderPager()]].
     */

    /**
     * @var Closure an anonymous function that is called once BEFORE rendering each data model.
     * It should have the similar signature as [[rowOptions]]. The return result of the function
     * will be rendered directly.
     */
    public $beforeRow;
    /**
     * @var Closure an anonymous function that is called once AFTER rendering each data model.
     * It should have the similar signature as [[rowOptions]]. The return result of the function
     * will be rendered directly.
     */
    public $afterRow;

    public $layout = "{summary}\n{items}\n{pager}";
    public $config = [];

/*    public static function begin($config = []) {
        self::boxBegin($config);
    }

    public static function end() {
        self::boxEnd();
    }*/

    public function init()
    {
    	if ($this->dataProvider === null) {
            throw new InvalidConfigException('The "dataProvider" property must be set.');
        }
        if ($this->emptyText === null) {
            $this->emptyText = Yii::t('yii', 'No results found.');
        }
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }

        //$this->tableOptions = ['class' => 'table ' . $this->type];
    }

    public function run()
    {
        self::listBegin($this->config);

		
		if ($this->showOnEmpty || $this->dataProvider->getCount() > 0) {
            $content = preg_replace_callback("/{\\w+}/", function ($matches) {
                $content = $this->renderSection($matches[0]);

                return $content === false ? $matches[0] : $content;
            }, $this->layout);
        } else {
            $content = $this->renderEmpty();
        }

        echo $content;

        // $options = $this->options;
        // $tag = ArrayHelper::remove($options, 'tag', 'div');
        // echo Html::tag($tag, $content, $options);

        self::listEnd();
    }

    /**
     * Renders a section of the specified name.
     * If the named section is not supported, false will be returned.
     * @param string $name the section name, e.g., `{summary}`, `{items}`.
     * @return string|bool the rendering result of the section, or false if the named section is not supported.
     */
    public function renderSection($name)
    {
        switch ($name) {
            case '{summary}':
                return $this->renderSummary();
            case '{items}':
                return $this->renderItems();
            case '{pager}':
                return $this->renderPager();
            case '{sorter}':
                return $this->renderSorter();
            default:
                return false;
        }
    }

    /**
     * Renders the data models.
     * @return string the rendering result.
     */
    public function renderItems()
    {
    	/*$caption = $this->renderCaption();
        $columnGroup = $this->renderColumnGroup();
        $tableHeader = $this->showHeader ? $this->renderTableHeader() : false;*/

        echo Html::beginTag('table', ['class' => 'table offer-table']);
        echo $this->renderTableBody();
        echo Html::endTag('table');

        /*$tableFooter = $this->showFooter ? $this->renderTableFooter() : false;
        $content = array_filter([
            $caption,
            $columnGroup,
            $tableHeader,
            $tableFooter,
            $tableBody,
        ]);*/

        //return Html::tag('table', implode("\n", $content), $this->tableOptions);
    }

    /**
     * Renders the table body.
     * @return string the rendering result.
     */
    public function renderTableBody()
    {
        $models = array_values($this->dataProvider->getModels());
        $keys = $this->dataProvider->getKeys();
        $rows = [];
        foreach ($models as $index => $model) {
            $key = $keys[$index];
            if ($this->beforeRow !== null) {
                $row = call_user_func($this->beforeRow, $model, $key, $index, $this);
                if (!empty($row)) {
                    $rows[] = $row;
                }
            }

            $rows[] = $this->renderTableRow($model, $key, $index);

            if ($this->afterRow !== null) {
                $row = call_user_func($this->afterRow, $model, $key, $index, $this);
                if (!empty($row)) {
                    $rows[] = $row;
                }
            }
        }

        /*if (empty($rows)) {
            $colspan = count($this->columns);
            return "<tbody>\n<tr><td colspan=\"$colspan\">" . $this->renderEmpty() . "</td></tr>\n</tbody>";
        } else {*/
            return "<tbody>\n" . implode("\n", $rows) . "\n</tbody>";
        //}
    }

    /**
     * Renders a table row with the given data model and key.
     * @param mixed $model the data model to be rendered
     * @param mixed $key the key associated with the data model
     * @param int $index the zero-based index of the data model among the model array returned by [[dataProvider]].
     * @return string the rendering result
     */
    public function renderTableRow($model, $key, $index)
    {
    	$row = Html::beginTag('tr');
    	$row = Html::beginTag('td', ['width' => '90']);
    	$row .= Html::beginTag('div', ['class' => 'cart-product-imitation']);
    	
    	$row .= Html::img(Utils::safePicture($model->picture, 'cover'), ['class' => 'media-object', 'alt' => $model->item->title, 'style' => "width: 150px;height: auto;border-radius: 4px;box-shadow: 0 1px 3px rgba(0,0,0,.15);"]);
    	
    	$row .= Html::endTag('div');
    	$row .= Html::endTag('td');

		$row .= Html::beginTag('td', ['class' => 'desc']);

		$row .= Html::beginTag('h3');
		$row .= Html::beginTag('a', ['class' => 'text-navy']);
		$row .= $model->item->title;
		$row .= Html::endTag('a');

		$row .= Html::beginTag('p', ['class' => 'small']);
		$row .= $model->item->category->name;
		$row .= Html::endTag('p');
		
		$row .= Html::beginTag('dl', ['class' => 'small m-b-none']);
		$row .= '<dt>Descrição</dt><dd>'.$model->description.'</dd>';
		$row .= Html::endTag('dl');
	    
	    $row .= Html::beginTag('div', ['class' => 'm-t-sm']);
		
		$row .= Html::beginTag('a', ['src' => Url::to(['offer/view', 'id' => $model->offerId]), 'class' => 'text-muted']);
		$row .= '<i class="fa fa-eye"></i> Ver item';
		$row .= Html::endTag('a') . ' | ';

		$row .= Html::beginTag('a', ['src' => Url::to(['offer/update', 'id' => $model->offerId]), 'class' => 'text-muted']);
		$row .= '<i class="fa fa-edit"></i> Editar item';
		$row .= Html::endTag('a');

		$row .= Html::endTag('div');
		$row .= Html::endTag('td');

		$totalDiscount = ($model->pricePerUnit * $model->discountPerUnit/100);
		$totalPrice = $model->pricePerUnit - $totalDiscount;

		$row .= Html::beginTag('td');

		$row .= Html::beginTag('dl', ['class' => 'small m-b-none']);
		$row .= '<dt>Preço</dt><dd>R$ ' . number_format($model->pricePerUnit, 2, ',', '.') .'</dd>';
		$row .= '<dt>Desconto</dt><dd>' . (($totalDiscount == 0) ? '--' : 'R$ ' . number_format($totalDiscount, 2, ',', '.')) .'</dd>';
		$row .= '<dt>Total</dt><dd>R$ ' . number_format($totalPrice, 2, ',', '.') .'</dd>';
		$row .= Html::endTag('dl');

		// promotion
        /*if ($totalDiscount > 0) {
	        $row .= Html::beginTag('s', ['class' => 'small text-muted']);
			$row .= 'R$ ' . number_format($totalDiscount, 2, ',', '.');
			$row .= Html::endTag('s');
		}*/

        $row .= Html::endTag('td');

        //$row .= Html::beginTag('td'); //width="65"
        //<input type="text" class="form-control" placeholder="2">
        //$row .= Html::endTag('td');

        $row .= Html::beginTag('td');

        
        foreach ($model->voucherFacts as $cupom) {
            $row .= Html::beginTag('dl', ['class' => 'small m-b-none']);
            
            $row .= '<dt>Voucher</dt><dd>' . $cupom->voucher->code .'</dd>';
    		$row .= '<dt>Desconto do Voucher</dt><dd>'.$cupom->voucher->discount.'%</dd>';
    		$row .= '<dt>Preço do Voucher</dt><dd>COIN ' . number_format(($cupom->voucher->discount * 1000), 2, ',', '.') .'</dd>';
    		
            $row .= Html::endTag('dl');
        }

        $row .= Html::endTag('td');

        $row .= Html::endTag('tr');

        /*if ($this->rowOptions instanceof Closure) {
            $options = call_user_func($this->rowOptions, $model, $key, $index, $this);
        } else {*/
            $options = []; //$this->rowOptions;
        //}
        //$options['data-key'] = is_array($key) ? json_encode($key) : (string) $key;

        //return Html::tag('tr', implode('', $cells), $options);
        return $row;
    }

    /**
     * Renders the HTML content indicating that the list view has no data.
     * @return string the rendering result
     * @see emptyText
     */
    public function renderEmpty()
    {
        $options = $this->emptyTextOptions;
        $tag = ArrayHelper::remove($options, 'tag', 'div');
        return Html::tag($tag, $this->emptyText, $options);
    }

    /**
     * Renders the summary text.
     */
    public function renderSummary()
    {
        $count = $this->dataProvider->getCount();
        if ($count <= 0) {
            return '';
        }
        $summaryOptions = $this->summaryOptions;
        $tag = ArrayHelper::remove($summaryOptions, 'tag', 'div');
        if (($pagination = $this->dataProvider->getPagination()) !== false) {
            $totalCount = $this->dataProvider->getTotalCount();
            $begin = $pagination->getPage() * $pagination->pageSize + 1;
            $end = $begin + $count - 1;
            if ($begin > $end) {
                $begin = $end;
            }
            $page = $pagination->getPage() + 1;
            $pageCount = $pagination->pageCount;
            if (($summaryContent = $this->summary) === null) {
                return Html::tag($tag, Yii::t('yii', 'Showing <b>{begin, number}-{end, number}</b> of <b>{totalCount, number}</b> {totalCount, plural, one{item} other{items}}.', [
                        'begin' => $begin,
                        'end' => $end,
                        'count' => $count,
                        'totalCount' => $totalCount,
                        'page' => $page,
                        'pageCount' => $pageCount,
                    ]), $summaryOptions);
            }
        } else {
            $begin = $page = $pageCount = 1;
            $end = $totalCount = $count;
            if (($summaryContent = $this->summary) === null) {
                return Html::tag($tag, Yii::t('yii', 'Total <b>{count, number}</b> {count, plural, one{item} other{items}}.', [
                    'begin' => $begin,
                    'end' => $end,
                    'count' => $count,
                    'totalCount' => $totalCount,
                    'page' => $page,
                    'pageCount' => $pageCount,
                ]), $summaryOptions);
            }
        }

        return Yii::$app->getI18n()->format($summaryContent, [
            'begin' => $begin,
            'end' => $end,
            'count' => $count,
            'totalCount' => $totalCount,
            'page' => $page,
            'pageCount' => $pageCount,
        ], Yii::$app->language);
    }

    /**
     * Renders the pager.
     * @return string the rendering result
     */
    public function renderPager()
    {
        $pagination = $this->dataProvider->getPagination();
        if ($pagination === false || $this->dataProvider->getCount() <= 0) {
            return '';
        }
        /* @var $class LinkPager */
        $pager = $this->pager;
        $class = ArrayHelper::remove($pager, 'class', LinkPager::className());
        $pager['pagination'] = $pagination;
        $pager['view'] = $this->getView();

        return $class::widget($pager);
    }

    /**
     * Renders the sorter.
     * @return string the rendering result
     */
    public function renderSorter()
    {
        $sort = $this->dataProvider->getSort();
        if ($sort === false || empty($sort->attributes) || $this->dataProvider->getCount() <= 0) {
            return '';
        }
        /* @var $class LinkSorter */
        $sorter = $this->sorter;
        $class = ArrayHelper::remove($sorter, 'class', LinkSorter::className());
        $sorter['sort'] = $sort;
        $sorter['view'] = $this->getView();

        return $class::widget($sorter);
    }
}

