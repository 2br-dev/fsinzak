<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/
namespace Affiliate\Config;

use RS\Orm\ConfigObject;
use RS\Orm\Type;
use RS\Router\Manager as RouterManager;

/**
 * Класс конфигурации модуля
 */
class File extends ConfigObject
{
    function _init()
    {
        parent::_init()->append([
            'use_geo_ip' => new Type\Integer([
                'description' => t('Использовать GeoIP для определения ближайшего филиала?'),
                'checkboxView' => [1, 0]
            ]),
            'coord_max_distance' => new Type\Real([
                'description' => t('Максимально допустимое отклонение широты и долготы филиала от пользователя, в градусах'),
                'hint' => t('Если филиал будет отдален от координат пользователя более, чем на указанную здесь величину, то он не будет автоматически выбран')
            ]),
            'confirm_city_select' => new Type\Integer([
                'description' => t('Запрашивать подтверждение города у пользователя'),
                'checkboxView' => [1, 0],
                'hint' => t('Запрашивается только один раз при первом посещении сайта')
            ])
        ]);
    }

    /**
     * Возвращает значения свойств по-умолчанию
     *
     * @return array
     */
    public static function getDefaultValues()
    {
        return parent::getDefaultValues() + [
            'tools' => [
                [
                    'url' => RouterManager::obj()->getAdminUrl('ajaxCheckGeoDetection', [], 'affiliate-ctrl'),
                    'title' => t('Проверить геолокацию'),
                    'description' => t('Отобразит окно с определенными координатами и городом филиальной сети'),
                    'class' => 'crud-add crud-sm-dialog'
                ]
            ]
            ];
    }
}
