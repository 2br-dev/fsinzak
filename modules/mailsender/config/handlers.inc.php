<?php
namespace MailSender\Config;
use \MailSender\Model\Source,
    \MailSender\Model\Filter,
    \MailSender\Model\Content,
    \MailSender\Model\Sample,
    \MailSender\Model\TriggerType,
    \MailSender\Model\Orm\MailTemplate;

/**
* Класс содержит обработчики событий, на которые подписан модуль
*/
class Handlers extends \RS\Event\HandlerAbstract
{
    /**
    * Добавляет подписку на события
    * 
    * @return void
    */
    function init()
    {
        $this
            ->bind('getroute')  //событие сбора маршрутов модулей
            ->bind('getmenus') //событие сбора пунктов меню для административной панели
            ->bind('cron')  //событие триггера            
            ->bind('mailsender.getsource') //событие сбора источников получателей 
            ->bind('mailsender.getfilter') //событие сбора источников получателей 
            ->bind('mailsender.getcontent')//событие сбора генераторов контента
            ->bind('mailsender.getsample') //событие сбора образцов оформления
            ->bind('trigger.gettypes')
            ->bind('trigger.exec');
    }
    
    /**
    * Возвращает маршруты данного модуля. Откликается на событие getRoute.
    * @param array $routes - массив с объектами маршрутов
    * @return array of \RS\Router\Route
    */
    public static function getRoute(array $routes) 
    {        
        $routes[] = new \RS\Router\Route('mailsender-front-unsubscribe',
        [
            '/unsubscribe/'
        ], null, t('Страница отписки от рассылки'));
        
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
            'title' => t('Рассылки'),
            'alias' => 'mailsender',
            'parent' => 'modules',
            'typelink' => 'link',
            'link' => '%ADMINPATH%/mailsender-templates/',
        ];
        $items[] = [
            'title' => t('Шаблоны'),
            'alias' => 'mailsender-templates',
            'link' => '%ADMINPATH%/mailsender-templates/',
            'parent' => 'mailsender',
            'typelink' => 'link',
            'sortn' => 0
        ];
        $items[] = [
            'title' => t('Триггеры'),
            'alias' => 'mailsender-triggers',
            'link' => '%ADMINPATH%/mailsender-triggers/',
            'parent' => 'mailsender',
            'typelink' => 'link',
            'sortn' => 2
        ];
        $items[] = [
            'title' => t('Адресная книга'),
            'alias' => 'mailsender-base',
            'link' => '%ADMINPATH%/mailsender-addressbook/',
            'parent' => 'mailsender',
            'typelink' => 'link',
            'sortn' => 3
        ];
        $items[] = [
            'title' => t('Журнал отправки'),
            'alias' => 'mailsender-logs',
            'link' => '%ADMINPATH%/mailsender-logs/',
            'parent' => 'mailsender',
            'typelink' => 'link',
            'sortn' => 4
        ];
        $items[] = [
            'title' => t('Исключенные получатели'),
            'alias' => 'mailsender-stoplist',
            'link' => '%ADMINPATH%/mailsender-stoplist/',
            'parent' => 'mailsender',
            'typelink' => 'link',
            'sortn' => 5
        ];
        return $items;
    }
    
    public static function MailSenderGetSource($list)
    {
        $list[] = new Source\RegisterUser();
        $list[] = new Source\Buyers();
        $list[] = new Source\AddressBook();
        $list[] = new Source\ProductView();
        
        if (\RS\Module\Manager::staticModuleExists('shop')) {
            $list[] = new Source\ProductBuy();
            $list[] = new Source\OrderInStatus();
            $list[] = new Source\ProductInOrder();
            $list[] = new Source\UserWithManager();
        }
        
        return $list;
    }
    
    public static function MailSenderGetFilter($list)
    {
        $list[] = new Filter\UserGroup();
        $list[] = new Filter\UserBalance();
        $list[] = new Filter\UserData();
        $list[] = new Filter\AddressBookGroup();
        return $list;
    }
    
    public static function MailSenderGetContent($list)
    {
        $list[] = new Content\LostCartProducts();
        $list[] = new Content\ProductsInOrder();
        $list[] = new Content\LastViewedProducts();
        $list[] = new Content\Products();
        return $list;
    }

    public static function MailSenderGetSample($list)
    {
        $list[] = new Sample\Sample1();
        $list[] = new Sample\Sample2();
        $list[] = new Sample\Sample3();
        $list[] = new Sample\Sample4();
        $list[] = new Sample\Sample5();
        $list[] = new Sample\Sample6();
        $list[] = new Sample\Sample7();
        $list[] = new Sample\Sample8();
        $list[] = new Sample\Sample9();
        return $list;
    }
    
    public static function TriggerGetTypes($list)
    {
        $list[] = new TriggerType\LostUser();
        
        if (\RS\Module\Manager::staticModuleExists('shop')) {
            $list[] = new TriggerType\LostCart();
            $list[] = new TriggerType\ProductInOrder();
            $list[] = new TriggerType\ChangeStatus();
        }
        
        return $list;
    }
    
    public static function TriggerExec($params)
    {
        $trigger = $params['trigger'];
        
        //Запускаем рассылку, связанным с триггером шаблонам
        $template_api = new \MailSender\Model\TemplateApi();
        $template_api->addRecipientsByTrigger($trigger, $params['data']);
    }
    
    public static function cron($params)
    {
        //Инициализируем маршруты
        \RS\Router\Manager::obj()->initRoutes();
        
        //Запускаем триггеры раз в 10 минут
        $config = \RS\Config\Loader::byModule(__CLASS__);
        foreach($params['minutes'] as $minute) {
            if (($minute % $config['trigger_interval']) == 0) 
            {
                $trigger_api = new \MailSender\Model\TriggerApi();
                $trigger_api->runTriggers();
                
                break;
            }
        }
        
        //Запускаем 1 шаг рассылки активных шаблонов
        $template_api = new \MailSender\Model\TemplateApi();
        $template_api->sendTemplates($params['last_time'], $params['current_time']);
    }
}