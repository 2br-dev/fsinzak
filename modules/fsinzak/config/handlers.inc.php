<?php
namespace Fsinzak\Config;

use Affiliate\Model\Orm\Affiliate;
use Catalog\Model\Api;
use Catalog\Model\Orm\Dir;
use Catalog\Model\Orm\Product;
use Fsinzak\Model\Behavior\AffiliateAffiliate;
use Fsinzak\Model\Behavior\CatalogProduct;
use Fsinzak\Model\Behavior\ShopOrder;
use Fsinzak\Model\Behavior\UsersUser;
use Fsinzak\Model\CartRulesApi;
use Fsinzak\Model\OrderApi;
use fsinzak\Model\Orm\Recipients;
use RS\Application\Application;
use RS\Config\Loader;
use RS\Controller\Admin\Helper\CrudCollection;
use RS\Event\HandlerAbstract;
use RS\Exception as RSException;
use RS\Html\Table\Element;
use RS\Html\Table\Type\Userfunc;
use RS\Module\AbstractModel\TreeList\AbstractTreeListIterator;
use RS\Orm\Type\ArrayList;
use RS\Orm\Type\Double;
use RS\Orm\Type\Integer;
use RS\Orm\Type\Richtext;
use RS\Orm\Type\Varchar;
use RS\Router\Route as RouterRoute;
use RS\Orm\Type;
use Shop\Model\Cart;
use Shop\Model\Orm\Order;
use Users\Model\Orm\User;

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
            ->bind('getmenus')
            ->bind('initialize')
            ->bind('getroute', null, null, 10)
            ->bind('cron')

            ->bind('orm.init.affiliate-affiliate')
            ->bind('orm.init.catalog-product')
            ->bind('orm.init.shop-order')
            ->bind('orm.init.catalog-dir')
            ->bind('orm.init.comments-comment')
            //->bind('orm.init.users-user')

            ->bind('orm.beforewrite.affiliate-affiliate')
            ->bind('orm.afterwrite.affiliate-affiliate')
            ->bind('orm.afterload.affiliate-affiliate')
            ->bind('orm.delete.affiliate-affiliate')
            ->bind('orm.beforewrite.shop-order')
            ->bind('orm.afterwrite.shop-order')

            ->bind('orm.afterwrite.shop-order')

            ->bind('controller.exec.shop-admin-orderctrl.index')
            ->bind('controller.exec.catalog-admin-ctrl.index')
            ->bind('controller.exec.article-admin-ctrl.index')
            ->bind('controller.beforeexec.affiliate-front-change')
            ->bind('controller.beforeexec.users-front-auth')
            ->bind('controller.afterexec.users-front-auth')
            ->bind('controller.beforeexec.article-block-lastnews')
            ->bind('controller.beforeexec.article-front-previewlist')
            ->bind('cart.change')
            ->bind('checkout.confirm')
        ;
    }

    static public function cron($params)
    {
        $sites = \RS\Site\Manager::getSiteList(); //Загружаем все мультисайты
        foreach($sites as $site) {
            //Загружаем настройки каждого сайта
            $config = \RS\Config\Loader::byModule(__CLASS__, $site['id']);
            $api = new OrderApi();
            foreach($params['minutes'] as $minute) {
                /**
                 * каждый час запускаем проверку
                 */
                if (($minute % 60) == 0) {
                    // Проверим заказы Которые ожидаеют оплаты для перевода в статус неоплачен
                    $api->checkOrdersWaitToPay($site['id']);
                    // Проверим заказы которые находятся в статусе
                    $api->checkOrdersProcessToColony($site['id']);
                }
            }
        }
    }

    static public function ormInitCommentsComment(\Comments\Model\Orm\Comment $orm)
    {
        $orm->getPropertyIterator()->append([
            'admin_ask' => new Type\Text([
                'description' => t('Ответ Админа')
            ])
        ]);
    }

    static public function controllerBeforeExecArticleFrontPreviewList($params)
    {
        $controller = $params['controller'];
        $article_api = $controller->api;
        $current_affiliate = \Affiliate\Model\AffiliateApi::getCurrentAffiliate();
        /**
         * @var \Article\Model\Api $article_api
         */
        $article_api->setFilter('affiliate_id', $current_affiliate['id'])->setFilter(['|affiliate_id:is' => 'NULL']);
        return $params;
    }

    static public function controllerExecArticleAdminCtrlIndex(CrudCollection $helper)
    {
        /**
         * @var Element $table
         */
        $table = $helper['table']->getTable();
        $columns = $table->getColumns();
        $last_column = array_pop($columns);
        $columns[] = new Userfunc('affiliate_id', t('Учреждение'), function ($value, $field){
            $article = $field->getRow();
            $affiliate = new \Affiliate\Model\Orm\Affiliate($article['affiliate_id']);
            $parent_affiliate = $affiliate->getParentAffiliate();
            return '<div>'.$parent_affiliate['title'].', '.$affiliate['title'].'</div>';
        });
        $columns[] = $last_column;
        $table->setColumns($columns);
    }

    static public function controllerBeforeExecArticleBlockLastNews($params)
    {
        $controller = $params['controller'];
        $article_api = $controller->article_api;
        $current_affiliate = \Affiliate\Model\AffiliateApi::getCurrentAffiliate();
        /**
         * @var \Article\Model\Api $article_api
         */
        $article_api->setFilter('affiliate_id', $current_affiliate['id'])->setFilter(['|affiliate_id:is' => 'NULL']);
        return $params;
    }

    static public function ormAfterWriteShopOrder($params)
    {
        /**
         * @var \Shop\Model\Orm\Order $order
         */
        $order = $params['orm'];
        $flag = $params['flag'];
        if($flag == $order::INSERT_FLAG){
            $items = [];
            $cart = $order->getCart();
            $order_data = $cart->getOrderData();
            $uniq = self::generateId();
            $items[$uniq] = array(
                'uniq' => $uniq,
                'title' => 'Коммиссия за оформление заказа',
                'entity_id' => 10001,
                'type' => $cart::TYPE_PRODUCT,
                'single_weight' => 0,
                'single_cost' => 100,
                'amount' => 1,
            );
        }
        if($flag == $order::UPDATE_FLAG){
            $fsinzak_config = Loader::byModule('fsinzak');
            $need_status = $fsinzak_config['status_to_send_pdf'];
            $order_status = $order->getStatus();
            if($order_status['id'] == $need_status){
                // Отправить сообщение с pdf заказа на почту, указанную у учреждения.
                $order_unserialized = unserialize($order['_serialized']);
                $affiliate_id = $order_unserialized['extrainfo']['affiliate']['data']['id'];
                $affiliate = new \Affiliate\Model\Orm\Affiliate($affiliate_id);
                $email_for_send = $affiliate->getEmailForSendPdf();
                $order->createXlsFile();
//                $order_pdf = $order->createPdf();
//                $pdf_generator = \RS\Helper\Pdf\PDFGenerator::class;
//                $pgf_template = 0;
            }
        }

    }

    /**
     * @param \RS\Controller\Admin\Helper\CrudCollection $helper
     */
    public static function controllerExecCatalogAdminCtrlIndex(\RS\Controller\Admin\Helper\CrudCollection $helper)
    {
        $line = new \RS\Html\Filter\Line();
        $filter_weight = new \RS\Html\Filter\Type\Text('weight', 'Вес');
        $filter_weight->setShowType();
        $line->addItem($filter_weight);
        $helper
            ->getFilter()
            ->getContainer()
            ->addLine($line);
        $helper->getFilter()->getContainer()->cleanItemsCache();

        // Выведем оповещение если есть товары с 0 Весом
        $product_api = new Api();
        $fsinzak_config = \RS\Config\Loader::byModule('fsinzak');
        $product_commission_id = $fsinzak_config['product_commission'];
        $product_weight0 = $product_api->setFilter('weight', 0)
                                        ->setFilter('id', $product_commission_id, '<>')
                                        ->getList();
        if(!empty($product_weight0)){
            $helper->setHeaderHtml('<p style="color: red; font-weight: bold; font-size: 18px;">Есть товары с нулевым весом</p>');
        }
    }

    public static function ormInitCatalogDir(Dir $orm)
    {
        $orm->getPropertyIterator()->append([
            t('Ограничения'),
                'limit_18' => new Integer([
                    'description' => t('Ограничение 18+'),
                    'checkBoxView' => [1,0],
                    'default' => 0
                ])
        ]);
    }

    public static function initialize()
    {
        User::attachClassBehavior(new UsersUser());
        Affiliate::attachClassBehavior(new AffiliateAffiliate());
        Product::attachClassBehavior(new CatalogProduct());
        Order::attachClassBehavior(new ShopOrder());
    }

    /**
     * Применяет правила к корзине
     *
     * @param array $params
     */
    public static function cartChange($params)
    {
        /**
         * @var Cart $cart
         */
        $cart = $params['cart'];
        $rules_api = new CartRulesApi();
        $rules_api->applyCartRules($cart);
    }

    public static function ormInitUsersUser(User $orm)
    {
        $orm->getPropertyIterator()->append([
            'pasport' => new Varchar([
                'description' => t('Паспорт')
            ]),
            'country' => new Varchar([
                'description' => t('Страна')
            ]),
            'region' => new Varchar([
                'description' => t('Регион/Область')
            ]),
            'city' => new Varchar([
                'description' => t('Город')
            ]),
            'address' => new Varchar([
                'description' => t('Адрес')
            ])
        ]);
    }

    public static function ormInitShopOrder(Order $orm)
    {
        $orm->getPropertyIterator()->append([
            'recipient_id' => new Integer([
                'description' => t('Получатель (id)'),
                'visible' => false
            ]),
            'pdf_sent' => new Integer([
                'description' => t('ПДФ заказа отправлен'),
                'visible' => false
            ]),
            'affiliate_id' => new Integer([
                'description' => t('Выбранный филиал'),
                'visible' => false
            ]),
            'create_crm_to_check_status_process' => new Integer([
                'description' => t('Создана задача на проверку заказа в статусе в Обработке'),
                'default' => 0
            ]),
            'change_status_process' => new Type\Datetime([
                'description' => t('Время изменения заказа на статус в Обработке на учреждении')
            ])
        ]);
    }

    public static function ormInitCatalogProduct(Product $orm)
    {
        $orm->getPropertyIterator()->append([
            t('Основные'),
                'limit_18' => new Integer([
                    'description' => t('Ограничение 18+'),
                    'checkBoxView' => [1, 0],
                    'maxLength' => 1
                ])
        ]);
    }

    public static function ormInitAffiliateAffiliate(Affiliate $orm)
    {
        $orm->getPropertyIterator()->append([
            t('Информация о доставке'),
                'delivery_info' => new Richtext([
                    'description' => t('Доставка')
                ]),
            t('Ограничения'),
                'limit_sum' => new Double([
                    'description' => t('Ограничение суммы заказа (руб.)'),
                    'default' => 0
                ]),
                'limit_weight' => new Double([
                    'description' => t('Ограничение веса заказа (г.)'),
                    'default' => 0
                ]),
                'periodicity' => new Integer([
                    'description' => t('Количество заказов в месяц'),
                    'hint' => t('Ограничение количество заказов для одного получателя в месяц. Перекрывается индивидуальными ограничениями получателя'),
                    'default' => 0
                ]),
            t('Контакты'),
                'email_for_pdf' => new Varchar([
                    'description' => t('E-mail для отправки бланка заказа pdf')
                ]),
            t('Действия после оформления заказа'),
                'time_to_not_payed_status' => new Integer(array(
                    'description' => t('Через сколько минут переводить заказ в статус - Не оплачено'),
                )),
                'creator_for_not_payment' => new Type\User(array(
                    'description' => t('Создатель задачи CRM на обработку не оплаченного заказа'),
                    'hint' => t('Создатель задачи в CRM'),
                )),
                'manager_for_not_payment' => new Type\User(array(
                    'description' => t('Менеджер, который будет обрабатывать не оплаченный заказ'),
                    'hint' => t('На него будет создаваться задача с CRM'),
                )),
            t('Действия после оплаты заказа'),
                'status_to_success_days' => new Type\Integer(array(
                    'description' => t('Количество дней чтобы переводить оплаченный и переданный заказ в статус "Выполнен"'),
                )),
                'creator_for_check_status' => new Type\User(array(
                    'description' => t('Создатель задачи CRM на проверку статуса В обработке на учреждении'),
                    'hint' => t('Создатель задачи в CRM'),
                )),
                'manager_for_check_status' => new Type\User(array(
                    'description' => t('Менеджер, который будет обрабатывать не доставленный заказ'),
                    'hint' => t('На него будет создаваться задача с CRM'),
                )),
            t('Товарные ограничения'),
                '_concomitant_' => new Type\UserTemplate('%fsinzak%/form/product/concomitant.tpl', '%fsinzak%/form/product/meconcomitant.tpl', [
                    'meVisible' => true  //Видимость при мультиредактировании
                ]),
                'concomitant' => new Type\Text([
                    'description' => t('Товарные ограничения'),
                    'visible' => false,
                ]),
                'concomitant_arr' => new Type\ArrayList([
                    'visible' => false
                ]),
            t('Правила для корзины'),
                '_cartrules_' => new Type\UserTemplate('%fsinzak%/form/affiliate/cartrules.tpl', '%fsinzak%/form/affiliate/cartrules.tpl', [
                    'meVisible' => true  //Видимость при мультиредактировании
                ]),
                'cartrules' => new Type\Text([
                    'description' => t('Товарные ограничения'),
                    'visible' => false,
                ]),
                'cartrules_arr' => new Type\ArrayList([
                    'visible' => false
                ]),
            t('Коммиссия за заказ'),
                'commission_fixed' => new Type\Integer([
                    'description' => t('Коммиссия за оформления заказа - фиксированная (руб.)'),
                    'default' => 0
                ]),
                'commission_percent' => new Type\Double([
                    'description' => t('Коммиссия за оформления заказа - процент'),
                    'default' => 0.00
                ]),
            t('Склад'),
                'warehouse' => new Integer([
                    'description' => t('Склад'),
                    'list' => array(array('\Catalog\Model\Warehouseapi','staticSelectList'))
                ])
        ]);
    }

    public static function ormAfterLoadAffiliateAffiliate($params)
    {
        $affiliate = $params['orm'];
        if (!empty($affiliate['concomitant'])) {
            $affiliate['concomitant_arr'] = @unserialize($affiliate['concomitant']);
        }
        if (!empty($affiliate['cartrules'])) {
            $affiliate['cartrules_arr'] = @unserialize($affiliate['cartrules']);
        }
    }

    public static function ormBeforeWriteAffiliateAffiliate($params)
    {
        $affiliate = $params['orm'];
        if ($affiliate->isModified('concomitant_arr')) { //Если изменялись сопутствующие
            $affiliate['concomitant'] = serialize($affiliate['concomitant_arr']);
        }
        if ($affiliate->isModified('cartrules_arr')) { //Если изменились правила для корзины
            $affiliate['cartrules'] = serialize($affiliate['cartrules_arr']);
        }
    }

    public static function ormBeforeWriteShopOrder($params)
    {
        $flag = $params['flag'];
        /**
         * @var \Shop\Model\Orm\Order $order
         */
        $order = $params['orm'];
        $config = \RS\Config\Loader::byModule('fsinzak');
        if($flag == 'insert'){
            $current_recipient = \Fsinzak\Model\RecipientsApi::getRecipientFromCookie('fsinzak-selected-recipient');
            $current_affiliate = \Affiliate\Model\AffiliateApi::getCurrentAffiliate();
            $order['recipient_id'] =  $current_recipient['id'];
            $order['affiliate_id'] = $current_affiliate['id'];

        }
        if($flag == $order::UPDATE_FLAG){
            if($order->isModified('status') && $order['status'] == $config['in_institution_status']){
                $order['change_status_process'] = date('Y-m-d H:i:s');
                $order['create_crm_to_check_status_process'] = 0;
            }
        }
    }

    public static function controllerBeforeExecUsersFrontAuth($params)
    {
        $action = $params['action'];
        $controller = $params['controller'];
        if($action == 'logout'){
            //При выходе из системы очистим корзину
            $current_cart = \Shop\Model\Cart::currentCart();
            $products = $current_cart->getProductItems();
            foreach ($products as $item) {
                unset($_SESSION[Cart::SESSION_CART_PRODUCTS][$item['product']['id']]);
            }
            $current_cart->clean();
            //Удалим выбранного получателя
            Application::getInstance()->headers->addCookie('fsinzak-selected-recipient', null, -1, '/', \Setup::$COOKIE_AUTH_DOMAIN);
        }
        return $params;
    }

    public static function controllerAfterExecUsersFrontAuth($params)
    {
        $is_auth = \RS\Application\Auth::isAuthorize();
        $current_user = \RS\Application\Auth::getCurrentUser();
        if($is_auth){
            $last_order = $current_user->getLastOrder();
            $last_order_recipient_id = $last_order['recipient_id'];
            $recipient_api = new \Fsinzak\Model\RecipientsApi();
            // Если есть последний заказ текущего получателя установим из заказа
            // Если нет - то возьмем первого из списка
            if($last_order_recipient_id){
                $recipient_api->setRecipient(intval($last_order_recipient_id));
            }else{
                $user_recipients = $current_user->getRecipients();
                $recipient_api->setRecipient(intval($user_recipients[0]['id']));
            }
        }
    }

    public static function controllerBeforeExecAffiliateFrontChange($params)
    {
        $current_cart = \Shop\Model\Cart::currentCart();
        $products = $current_cart->getProductItems();
        foreach ($products as $item) {
            unset($_SESSION[Cart::SESSION_CART_PRODUCTS][$item['product']['id']]);
        }
        $current_cart->clean();
    }

    public static function controllerExecShopAdminOrderCtrlIndex(CrudCollection $helper)
    {
        /**
         * @var Element $table
         */
        $table = $helper['table']->getTable();
        $columns = $table->getColumns();
        $last_column = array_pop($columns);
        $columns[] = new Userfunc('recipient', t('Получатель'), function($value, $field){
            $order = $field->getRow();
            $recipient = new Recipients($order['recipient_id']);
            return '<div>'.$recipient->getFio(false).', '.$recipient->getBirthday('d.m.Y').'</div>';
        });
        $columns[] = new Userfunc('colony', t('Учреждение'), function($value, $field){
            $order = $field->getRow();
            return '<div>'.$order->getColonyTitle().'</div>';
        });
        $columns[] = new Userfunc('pdf_sent', t('Отправить бланк'), function ($value, $field){
            $order = $field->getRow();
            return '<a id="sent-pdf" class="crud-get" data-url="/admin/fsinzak-tools/?do=sentOrderBlank" data-order="'.$order['id'].'">Отправить бланк</a>';
        });
        $columns[] = $last_column;
        $table->setColumns($columns);
    }


    /**
     * Применяет правила в конце оформления заказа
     *
     * @param array $params
     * @return void
     * @throws RSException
     */
    public static function checkoutConfirm($params)
    {
        /** @var Cart $cart */
        $cart = $params['cart'];
        $cart->triggerChangeEvent();
    }


    /**
     * Возвращает маршруты данного модуля. Откликается на событие getRoute.
     * @param array $routes - массив с объектами маршрутов
     * @return array of \RS\Router\Route
     */
    public static function getRoute(array $routes)
    {
        //Получатели
        $routes[] = new RouterRoute('fsinzak-front-myrecipients', '/my/recipients/', null, t('Получатели'));
//        $routes[] = new RouterRoute('users-front-register', '/register/', [
//            'controller' => 'fsinzak-front-registr'
//        ], t('Регистрация пользователя'));
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
            'title' => 'Пункт модуля fsinzak',
            'alias' => 'fsinzak-control',
            'link' => '%ADMINPATH%/fsinzak-control/',
            'parent' => 'modules',
            'sortn' => 40,
            'typelink' => 'link',
        ];
        $items[] = [
            'title' => 'Получатели',
            'alias' => 'fsinzak-recipientsctrl',
            'link' => '%ADMINPATH%/fsinzak-recipientsctrl/',
            'parent' => 'modules',
            'sortn' => 50,
            'typelink' => 'link',
        ];
        return $items;
    }


    public static function ormDeleteAffiliateAffiliate($params)
    {
        $affiliate = $params['orm'];
        if($affiliate['warehouse']){
            $warehouse = new \Catalog\Model\Orm\WareHouse($affiliate['warehouse']);
            $warehouse['affiliate_id'] = 0;
            $warehouse->update();
        }
    }

    public static function ormAfterWriteAffiliateAffiliate($params)
    {
        /**
         * @var \Affiliate\Model\Orm\Affiliate $affiliate
         */
        $affiliate = $params['orm'];
        if($affiliate->isModified('warehouse')){
            $warehouse = new \Catalog\Model\Orm\WareHouse($affiliate['warehouse']);
            $warehouse['affiliate_id'] = $affiliate['id'];
            $warehouse->update();
        }
    }

    /**
     * Генерирует идентификатор элемента заказа
     *
     */
    public static function generateId()
    {
        $symb = array_merge(range('a', 'z'), range('0', '9'));
        return \RS\Helper\Tools::generatePassword(10, $symb);
    }
}
