<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/
namespace Affiliate\Model\Orm;

use Catalog\Model\Orm\WareHouse;
use RS\Debug\Action as DebugAction;
use RS\Orm\OrmObject;
use RS\Orm\Request as OrmRequest;
use RS\Orm\Request;
use RS\Orm\Type;
use RS\Router\Manager as RouterManager;
use RS\Site\Manager as SiteManager;
use Shop\Model\RegionApi;

/**
 * Объект - филиал
 * --/--
 * @property integer $id Уникальный идентификатор (ID)
 * @property integer $site_id ID сайта
 * @property string $title Наименование(регион или город)
 * @property string $alias URL имя
 * @property integer $parent_id Родитель
 * @property integer $clickable Разрешить выбор данного филиала
 * @property integer $cost_id Тип цен
 * @property string $short_contacts Краткая контактная информация
 * @property string $contacts Контактная информация
 * @property float $coord_lng Долгота
 * @property float $coord_lat Широта
 * @property integer $skip_geolocation Не выбирать данный филиал с помощью геолокации
 * @property integer $sortn Порядк. №
 * @property integer $is_default Филиал по умолчанию
 * @property integer $is_highlight Выделить филиал визуально
 * @property integer $public Публичный
 * @property integer $linked_region_id Связанный регион
 * @property string $meta_title Заголовок
 * @property string $meta_keywords Ключевые слова
 * @property string $meta_description Описание
 * --\--
 */
class Affiliate extends OrmObject
{
    protected static $table = 'affiliate';

    function _init()
    {
        parent::_init()->append([
            t('Основные'),
                'site_id' => new Type\CurrentSite(),
                'title' => new Type\Varchar([
                    'description' => t('Наименование(регион или город)'),
                    'checker' => ['ChkEmpty', t('Укажите URL имя')],
                    'attr' => [[
                        'data-autotranslit' => 'alias'
                    ]],
                    'meVisible' => false,
                    'index' => true
                ]),
                'alias' => new Type\Varchar([
                    'description' => t('URL имя'),
                    'maxLength' => 150,
                    'meVisible' => false,
                    'checker' => ['ChkEmpty', t('Укажите URL имя')]
                ]),
                'parent_id' => new Type\Integer([
                    'description' => t('Родитель'),
                    'list' => [['\Affiliate\Model\AffiliateApi', 'staticRootList']]
                ]),
                'clickable' => new Type\Integer([
                    'description' => t('Разрешить выбор данного филиала'),
                    'default' => 1,
                    'checkboxView' => [1, 0],
                    'hint' => t('Если снять флажок, то элемент будет считаться группой филиалов, которую нельзя выбрать'),
                ]),
                'cost_id' => new Type\Integer([
                    'description' => t('Тип цен'),
                    'list' => [['\Catalog\Model\CostApi', 'staticSelectList'], [0 => t('Не выбрано')]],
                    'hint' => t('Выбранный тип цен будет являться типом цен по-умолчанию, при выборе данного филиала'),
                ]),
                'short_contacts' => new Type\Text([
                    'description' => t('Краткая контактная информация')
                ]),
                'contacts' => new Type\Richtext([
                    'description' => t('Контактная информация')
                ]),
                'coord_lng' => new Type\Decimal([
                    'maxLength' => 10,
                    'decimal' => 6,
                    'description' => t('Долгота'),
                    'allowempty' => true,
                    'requestType' => 'string',
                    'visible' => false,
                ]),
                'coord_lat' => new Type\Decimal([
                    'maxLength' => 10,
                    'decimal' => 6,
                    'description' => t('Широта'),
                    'allowempty' => true,
                    'visible' => false,
                    'requestType' => 'string',
                ]),
                '_geo' => new Type\MixedType([
                    'description' => t('Расположение на карте'),
                    'visible' => true,
                    'template' => '%affiliate%/form/affiliate/geo.tpl'
                ]),
                'skip_geolocation' => new Type\Integer([
                    'maxLength' => 1,
                    'description' => t('Не выбирать данный филиал с помощью геолокации'),
                    'default' => 0,
                    'allowEmpty' => false,
                    'checkboxView' => [1, 0]
                ]),
                'sortn' => new Type\Integer([
                    'maxLength' => '11',
                    'description' => t('Порядк. №'),
                    'visible' => false,
                ]),
                'is_default' => new Type\Integer([
                    'maxLength' => 1,
                    'description' => t('Филиал по умолчанию'),
                    'meVisible' => false,
                    'checkboxView' => [1, 0],
                    'allowEmpty' => false,
                    'hint' => t('Будет выбран, если ни один филиал по геолокации не будет определен')
                ]),
                'is_highlight' => new Type\Integer([
                    'maxLength' => 1,
                    'description' => t('Выделить филиал визуально'),
                    'checkboxView' => [1, 0]
                ]),
                'public' => new Type\Integer([
                    'description' => t('Публичный'),
                    'default' => 1,
                    'checkboxView' => [1, 0]
                ]),
                'linked_region_id' => (new Type\Integer())
                    ->setDescription('Связанный регион')
                    ->setTree('\Shop\Model\RegionApi::staticTreeList', 0, [0 => t('- Не выбран -')]),
            t('Мета-тэги'),
                'meta_title' => new Type\Varchar([
                    'maxLength' => '1000',
                    'description' => t('Заголовок'),
                ]),
                'meta_keywords' => new Type\Varchar([
                    'maxLength' => '1000',
                    'description' => t('Ключевые слова'),
                ]),
                'meta_description' => new Type\Varchar([
                    'maxLength' => '1000',
                    'viewAsTextarea' => true,
                    'description' => t('Описание'),
                ]),
        ]);

        $this->addIndex(['site_id', 'alias'], self::INDEX_UNIQUE);
    }

    /**
     * Возвращает отладочные действия, которые можно произвести с объектом
     *
     * @return DebugAction\AbstractAction[]
     */
    public function getDebugActions()
    {
        return [
            new DebugAction\Edit(RouterManager::obj()->getAdminPattern('edit', [':id' => '{id}'], 'affiliate-ctrl')),
            new DebugAction\Delete(RouterManager::obj()->getAdminPattern('del', [':chk[]' => '{id}'], 'affiliate-ctrl'))
        ];
    }

    /**
     * Выполняется перед сохранением объекта
     *
     * @param string $flag
     * @return void
     */
    function beforeWrite($flag)
    {
        if ($this['coord_lng'] === '') $this['coord_lng'] = null;
        if ($this['coord_lat'] === '') $this['coord_lat'] = null;

        if ($flag == self::INSERT_FLAG && !$this->isModified('sortn')) {
            $q = OrmRequest::make()
                ->select('MAX(sortn) max_sort')
                ->from($this)
                ->where([
                    'site_id' => $this['site_id'],
                    'parent_id' => $this['parent_id'],
                ]);

            $this['sortn'] = $q->exec()->getOneField('max_sort', -1) + 1;
        }
    }

    /**
     * Выполняется после сохранения объекта
     *
     * @param string $flag
     */
    function afterWrite($flag)
    {
        if ($this['is_default']) {
            //Флаг "по умолчанию", может быть только у одного филиала в рамках сайта
            OrmRequest::make()
                ->update($this)
                ->set('is_default = 0')
                ->where([
                    'site_id' => $this['site_id']
                ])
                ->where("id != '#id'", ['id' => $this['id']])
                ->exec();
        }
    }

    /**
     * Удаляет объект
     *
     * @return bool
     */
    function delete()
    {
        if ($result = parent::delete()) {
            //Удаляем у складов ссылку на данный филиал
            OrmRequest::make()
                ->update(new WareHouse())
                ->set(['affiliate_id' => 0])
                ->where([
                    'affiliate_id' => $this['id']
                ])->exec();
        }
        return $result;
    }

    /**
     * Возвращает клон текущего объекта
     *
     * @return static
     */
    function cloneSelf()
    {
        /** @var self $clone */
        $clone = parent::cloneSelf();
        unset($clone['alias']);
        return $clone;
    }

    /**
     * Возвращает список ID связанных с филиалом складов,
     * а также складов связанных со всеми филиалами
     *
     * @return int[]
     */
    function getLinkedWarehouses()
    {
        $warehouse_ids = Request::make()
            ->select('id')
            ->from(new WareHouse())
            ->where([
                'site_id' => $this['site_id']
            ])
            ->whereIn('affiliate_id', [0, $this['id']])
            ->exec()->fetchSelected(null, 'id');

        return $warehouse_ids;
    }

    /**
     * Возвращает URL на страницу контактов филиала
     *
     * @param bool $absolute
     * @return string
     */
    function getContactPageUrl($absolute = false)
    {
        $affiliate_id = $this['alias'] ?: $this['id'];
        return RouterManager::obj()->getUrl('affiliate-front-contacts', ['affiliate' => $affiliate_id], $absolute);
    }

    /**
     * Возвращает URL на страницу изменения филиала на текущий
     *
     * @param string $referer URL для перенаправления после смены филиала
     * @param bool $absolute Если true, то будет возвращена абсолютная ссылка
     * @return string
     */
    function getChangeAffiliateUrl($referer, $absolute = false)
    {
        $affiliate_id = $this['alias'] ?: $this['id'];
        return RouterManager::obj()->getUrl('affiliate-front-change', ['affiliate' => $affiliate_id, 'referer' => $referer], $absolute);
    }
}
