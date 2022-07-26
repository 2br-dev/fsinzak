<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/
namespace Statistic\Model\Orm;
use \RS\Orm\Type;

/**
 * Класс тип источника пользователя
 * @package Statistic\Model\Orm
 * --/--
 * @property integer $id Уникальный идентификатор (ID)
 * @property integer $site_id ID сайта
 * @property string $title Название
 * @property integer $parent_id Категория
 * @property string $referer_site Домен источника перехода
 * @property integer $referer_request_uri_regular Использовать регулярное выражения для части адреса источника
 * @property string $referer_request_uri Часть адреса источника до знака ?
 * @property array $params_arr Массив параметров адреса источника после знака ?
 * @property string $params Массив параметров адреса источника после знака ? в сериализованном виде
 * @property array $_params Массив параметров адреса источника после знака ?
 * @property integer $sortn Приоритет
 * --\--
 */
class SourceType extends \RS\Orm\OrmObject
{
    protected static
        $table = 'statistic_user_source_type';
        
    function _init()
    {
        parent::_init()->append([
            'site_id' => new Type\CurrentSite(),
            'title' => new Type\Varchar([
                'description' => t('Название'),
            ]),
            'parent_id' => new Type\Integer([
                'description' => t('Категория'),
                'list' => [['\Statistic\Model\SourceTypeDirsApi', 'staticSelectList'], [0 => t('Без группы')]]
            ]),
            'referer_site' => new Type\Varchar([
                'description' => t('Домен источника перехода'),
                'hint' => t('Например google.com. Переход по ссылке с указанного домена будет устанавливать текущий тип источника'),
                'Checker' => ['chkEmpty',t('Необходимо заполнить поле домен')],
            ]),
            'referer_request_uri_regular' => new Type\Integer([
                'description' => t('Использовать регулярное выражения для части адреса источника'),
                'hint' => t('Если не отмечано, то происходит поиск полного совпадения'),
                'maxLength' => 1,
                'default' => 0,
                'checkboxView' => [1, 0]
            ]),
            'referer_request_uri' => new Type\Varchar([
                'description' => t('Часть адреса источника до знака ?'),
                'hint' => t('Например /webmasters/. Если пусто учитываться не будет')
            ]),
            'params_arr' => new Type\ArrayList([
                'description' => t('Массив параметров адреса источника после знака ?'),
                'visible' => false,
            ]),
            'params' => new Type\Text([
                'description' => t('Массив параметров адреса источника после знака ? в сериализованном виде'),
                'visible' => false,
            ]),
            '_params' => new Type\ArrayList([
                'description' => t('Массив параметров адреса источника после знака ?'),
                'hint' => t('Например ?param1=answer1&param1=answer2. Если не указано учитываться не будет'),
                'template' => '%statistic%/form/source_type/params_data.tpl',
            ]),
            'sortn' => new Type\Integer([
                'maxLength' => '11',
                'description' => t('Приоритет'),
                'hint' => t('Чем больше тем раньше будет проверяться'),
                'default' => '10'
            ]),
        ]);
    }

    /**
     * Действия при загрузке
     */
    function afterObjectLoad()
    {
        //Смотрим параметры
        $this['params_arr'] = [];
        if (!empty($this['params'])){
            $this['params_arr'] = (array)@unserialize($this['params']);;
        }
    }


    /**
     * Действия перед записью типа
     *
     * @param string $flag - insert или update
     * @return false|null|void
     */
    function beforeWrite($flag)
    {
        //Преобразуем свойства из виртуального свойства _propsdata
        if ($this->isModified('_params')) {
            $this['params_arr'] = $this->convertPropsData($this['_params']);
        }

        if (!empty($this['params_arr'])){
            $this['params'] = @serialize($this['params_arr']);
        }
    }

    /**
     * Конвертирует формат сведений о параметрах
     *
     * @param array $_propsdata ['key' => [ключ1, ключ2,...],  'value' => [значение1, значение2, ...]]
     * @return array ['ключ1' => 'значение1', 'ключ2' => 'значение2',...]
     */
    function convertPropsData($_propsdata)
    {
        $props_data_arr = [];
        if (!empty($_propsdata)) {
            foreach($_propsdata['key'] as $n => $val) {
                if ($val !== '') {
                    $props_data_arr[$val] = $_propsdata['val'][$n];
                }
            }
        }
        return $props_data_arr;
    }
}