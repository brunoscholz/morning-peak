<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace base\library\utils;

use base\AppAdaptor;
use base\library\extensions\bootstrap\widgets\UiLabel;
use base\library\components\UiHtml;

/**
 * StatusUtil class file.
 * 
 * @package base\library\utils
 */
class StatusUtil
{
    /**
     * Active status constant.
     */
    const STATUS_ACTIVE = 1;
    /**
     * Inactive status constant.
     */
    const STATUS_INACTIVE = 0;
    /**
     * Pending status constant.
     */
    const STATUS_PENDING    = 2;

    /**
     * Gets label for the status.
     * @param string $data ActiveRecord of the model.
     * @return string
     */
    public static function getLabel($data)
    {
        if(is_array($data))
        {
            $data = (object)$data;
        }
        if ($data->status == self::STATUS_ACTIVE)
        {
            return AppAdaptor::t('application', 'Ativo');
        }
        else if ($data->status == self::STATUS_INACTIVE)
        {
            return AppAdaptor::t('application', 'Inativo');
        }
        else if ($data->status == self::STATUS_PENDING)
        {
            return AppAdaptor::t('application', 'Pendente');
        }
    }

    /**
     * Gets status dropdown.
     * @return array
     */
    public static function getDropdown()
    {
        return array(
            self::STATUS_ACTIVE     => AppAdaptor::t('application', 'Ativo'),
            self::STATUS_INACTIVE   => AppAdaptor::t('application', 'Inativo')
        );
    }

    /**
     * Renders label for the status.
     * @param string $data ActiveRecord of the model.
     * @return string
     */
    public static function renderLabel($data)
    {
        if(is_array($data))
        {
            $dataObject = (object)$data;
            $value      = StatusUtil::getLabel($dataObject);
            $className  = AppAdaptor::getObjectClassName($dataObject);
            $id         = strtolower($className) . '-status-' . $dataObject->id;
        }
        else
        {
            $value      = StatusUtil::getLabel($data);
            $className  = AppAdaptor::getObjectClassName($data);
            $id         = strtolower($className) . '-status-' . $data->id;
        }
        if ($value == AppAdaptor::t('application', 'Ativo'))
        {
            return UiLabel::widget(['content' => $value, 'modifier' => UiHtml::COLOR_SUCCESS, 'id' => $id]);
        }
        elseif ($value == AppAdaptor::t('application', 'Inativo'))
        {
            return UiLabel::widget(['content' => $value, 'modifier' => UiHtml::COLOR_WARNING, 'id' => $id]);
        }
        elseif ($value == AppAdaptor::t('application', 'Pendente'))
        {
            return UiLabel::widget(['content' => $value, 'modifier' => UiHtml::COLOR_DANGER, 'id' => $id]);
        }
    }
}