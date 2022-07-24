<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/

namespace Affiliate\Config;

use Affiliate\Model\AffiliateApi;
use Affiliate\Model\Behavior\ArticleArticle;
use Affiliate\Model\Behavior\CatalogWarehouse;
use Affiliate\Model\Behavior\MenuMenu;
use Affiliate\Model\MenuType\Affiliate as MenuTypeAffiliate;
use Article\Model\Orm\Article;
use Catalog\Model\CostApi;
use Catalog\Model\Orm\WareHouse;
use Catalog\Model\WareHouseApi;
use Menu\Model\MenuType;
use Menu\Model\Orm\Menu;
use RS\Config\Loader as ConfigLoader;
use RS\Db\Exception as DbException;
use RS\Event\HandlerAbstract;
use RS\Orm\AbstractObject;
use RS\Orm\Type as OrmType;
use RS\Router\Manager as RouterManager;
use RS\Router\Route;
use Shop\Model\Orm\Address;
use Shop\Model\Orm\Order;
use Shop\Model\Orm\Region;

/**
 * Класс содержит обработчики событий, на которые подписан модуль
 */
class Handlers extends HandlerAbstract
{
    /**
     * Добавляет подписку на события
     *
     * @return void
     */
    function init()
    {
        $this
            ->bind('order.setdefaultaddress')
            ->bind('orm.init.catalog-warehouse')
            ->bind('orm.init.article-article')
            ->bind('orm.init.menu-menu')
            ->bind('orm.beforewrite.shop-order')
            ->bind('controller.afterinit.menu-block-menu')
            ->bind('getroute')//событие сбора маршрутов модулей
            ->bind('getmenus')//событие сбора пунктов меню для административной панели
            ->bind('getwarehouses', null, null, 10)
            ->bind('menu.gettypes')
            ->bind('getpages')
            ->bind('start')
            ->bind('initialize');
    }

    /**
     * Расширяем ORM Объекты других модулей
     */
    public static function initialize()
    {
        Article::attachClassBehavior(new ArticleArticle());
        WareHouse::attachClassBehavior(new CatalogWarehouse());
        Menu::attachClassBehavior(new MenuMenu());
    }

    /**
     * Устанавливает адрес в заказе на основе выбранного филиала
     *
     * @param array $params - параметры события
     */
    public static function orderSetDefaultAddress(array $params)
    {
        /** @var Order $order */
        $order = $params['order'];
        $affiliate = AffiliateApi::getCurrentAffiliate();
        if (!empty($affiliate['linked_region_id'])) {
            $region = new Region($affiliate['linked_region_id']);
            if ($region['id']) {
                $new_address = Address::createFromRegion($region);
                $order->setAddress($new_address);
            }
        }
    }

    /**
     * Добавляет к складу поле "Филиал"
     *
     * @param WareHouse $warehouse
     */
    public static function ormInitCatalogWarehouse(WareHouse $warehouse)
    {
        $warehouse->getPropertyIterator()->append([
            t('Основные'),
            'affiliate_id' => new OrmType\Integer([
                'description' => t('Филиал'),
                'allowEmpty' => false,
                'default' => 0,
                'tree' => [['\Affiliate\Model\AffiliateApi', 'staticTreeList'], 0, [0 => t('Не задано')]],
                'hint' => t('Информация об остатке на складе в карточке товара и оформлении заказа будет отображаться только при выборе данного филиала')
            ]),
        ]);
    }

    public static function ormInitArticleArticle(Article $article)
    {
        $article->getPropertyIterator()->append([
            t('Фильтр по городам'),
            'affiliate_id' => new OrmType\Integer([
                'description' => t('Фильтр по городам'),
                'default' => null,
                'tree' => [['\Affiliate\Model\AffiliateApi', 'staticTreeList'], 0, [0 => t('Любой город')]],
            ]),
        ]);
    }

    /**
     * Добавляем фильтр по филиалу к пунктам меню
     *
     * @param \Menu\Controller\Block\Menu $menu_block_controller
     */
    public static function controllerAfterInitMenuBlockMenu($menu_block_controller)
    {
        $affiliate = AffiliateApi::getCurrentAffiliate();
        if ($affiliate['id']) {
            $menu_block_controller->api->setFilter([
                [
                    'affiliate_id' => 0,
                    '|affiliate_id' => $affiliate['id']
                ]
            ]);
        }
    }

    /**
     * Добавим связь пунктов меню с филиалами
     *
     * @param Menu $menu
     * @return void
     */
    public static function ormInitMenuMenu(Menu $menu)
    {
        $menu->getPropertyIterator()->append([
            t('Основные'),
            'affiliate_id' => new OrmType\Integer([
                'description' => t('Филиал'),
                'allowEmpty' => false,
                'default' => 0,
                'tree' => [['\Affiliate\Model\AffiliateApi', 'staticTreeList'], 0, [0 => t('Не задано')]],
                'hint' => t('Данный пункт меню будет отображаться только при выборе указанного филиала')
            ]),
        ]);
    }

    /**
     * Сохраняет в заказе сведения о выбранном на момент оформления филиале
     *
     * @param array $params - массив с параметрами
     */
    public static function ormBeforeWriteShopOrder($params)
    {
        if (!RouterManager::obj()->isAdminZone() && $params['flag'] == AbstractObject::INSERT_FLAG) {
            $affiliate = AffiliateApi::getCurrentAffiliate();
            if ($affiliate['id']) {
                /** @var Order $order */
                $order = $params['orm'];
                $order->addExtraInfoLine(t('Выбранный город при оформлении'), $affiliate['title'], ['id' => $affiliate['id']], 'affiliate');
            }
        }
    }

    /**
     * Возвращает маршруты данного модуля. Откликается на событие getRoute.
     * @param array $routes - массив с объектами маршрутов
     * @return array of \RS\Router\Route
     */
    public static function getRoute(array $routes)
    {
        $routes[] = new Route('affiliate-front-change', '/change-affiliate/{affiliate}/', null, t('Смена текущего филиала'));
        $routes[] = new Route('affiliate-front-contacts', '/contacts/{affiliate}/', null, t('Контакты филиала'));
        $routes[] = new Route('affiliate-front-affiliates', '/affiliates/', null, t('Выбор филиалов'));

        return $routes;
    }

    /**
     * Возвращает пункты меню этого модуля в виде массива
     * @param array $items - массив с пунктами меню
     * @return array
     */
    public static function getMenus($items)
    {
        $items[] = [
            'title' => t('Филиалы в городах'),
            'alias' => 'affiliate',
            'link' => '%ADMINPATH%/affiliate-ctrl/',
            'parent' => 'modules',
            'typelink' => 'link',
        ];
        return $items;
    }

    /**
     * Обрабатывает событие выборки доступных складов
     *
     * @param array $params
     */
    public static function getWarehouses($params)
    {
        $affiliate = AffiliateApi::getCurrentAffiliate();
        if ($affiliate['id']) {
            /** @var WareHouseApi $warehouse_api */
            $warehouse_api = $params['warehouse_api'];
            $warehouse_api->setFilter([
                [
                    'affiliate_id' => 0,
                    '|affiliate_id' => $affiliate['id']
                ]
            ]);
        }
    }

    /**
     * Добавляет в систему собственный тип меню
     *
     * @param MenuType\AbstractType[] $types
     * @return MenuType\AbstractType[]
     */
    public static function menuGetTypes($types)
    {
        $types[] = new MenuTypeAffiliate();
        return $types;
    }

    /**
     * Устанавливает тип цен по умолчанию
     */
    public static function start()
    {
        $config = ConfigLoader::byModule('affiliate');
        if (!RouterManager::obj()->isAdminZone() && $config['installed']) {
            $affiliate = AffiliateApi::getCurrentAffiliate();
            if ($affiliate['cost_id']) {
                CostApi::setSessionDefaultCost($affiliate['cost_id']);
            }
        }
    }

    /**
     * Добавляет страницы контактов филиалов в sitemap.xml
     *
     * @param array $pages - список
     * @return array
     * @throws DbException
     */
    public static function getPages($pages)
    {
        $api = new AffiliateApi();
        $api->setFilter([
            'public' => 1,
            'clickable' => 1
        ]);

        $list = $api->getListAsArray();

        $router = RouterManager::obj();
        foreach ($list as $item) {
            $url = $router->getUrl('affiliate-front-contacts', ['affiliate' => $item['alias']]);
            $pages[$url] = [
                'loc' => $url
            ];
        }
        return $pages;
    }
}
