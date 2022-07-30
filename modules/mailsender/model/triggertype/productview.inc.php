<?php
namespace MailSender\Model\TriggerType;
use \RS\Orm\Type;

/**
* Триггер - Пользователь, просматривавший товары в определенный промежуток времени
*/
class ProductView extends AbstractType
{
    /**
    * Возвращает название триггера
    * 
    * @return string
    */
    function getTitle()
    {
        return t('Пользователь, просматривавший товары в определенный период');
    }
    
    /**
    * Возвращает описание триггера
    * 
    * @return string
    */
    function getDescription()
    {
        return t('Триггер срабатывает, в момент, когда пользователь просматривает определенные товары в заданный диапазон дат');
    }
    
    /**
    * Возвращает объект с настройками типа триггера
    * 
    * @return \RS\Orm\FormObject | null
    */
    function getSettingsObject()
    {
        return new \RS\Orm\FormObject(new \RS\Orm\PropertyIterator([
            'products' => new Type\ArrayList([
                'runtime' => false,
                'description' => t('Товары'),
                'dialog' => new \Catalog\Model\ProductDialog('settings[products]', false),
                'template' => '%mailsender%/form/trigger/type/product_view_products.tpl',
                'checker' => ['ChkEmpty', t('Не указаны товары')]
            ]),
            'date_from' => new Type\Datetime([
                'description' => t('Дата, от'),
                'hint' => t('В системе должно быть настроено хранение истории посещений товаров пользователя на период, указанный здесь'),
                'checker' => ['ChkEmpty', t('Обязательное поле')]
            ]),
            'date_to' => new Type\Datetime([
                'description' => t('Дата, до'),
                'hint' => t('В системе должно быть настроено хранение истории посещений товаров пользователя на период, указанный здесь'),
                'checker' => ['ChkEmpty', t('Обязательное поле')],
                ' checker' => [function($_this, $value) {
                    if ($_this['days_from'] > $value) {
                        return t('M должно быть больше N');
                    }
                    return true;
                }]
            ])
        ]));
    }

    
    /**
    * Проверяет, должен ли сработать триггер сейчас.
    * Если должен, то вернется массив объектов \MailSender\Model\triggerData
    * 
    * @return \MailSender\Model\triggerData[]
    */
    function match()
    {        
        //Выбираем логи по дате
        $q = \RS\Orm\Request::make()
            ->select('user_id, oid as product_id')
            ->from(new \Users\Model\Orm\Log(), 'L')
            ->where([
                'L.class' => 'Catalog\Model\Logtype\ShowProduct',
                'L.site_id' => $this->trigger['site_id'],
            ])
            ->where("L.dateof >= '#date_from' AND L.dateof <= '#date_to'", [
                'date_from' => $this->settings['date_from'],
                'date_to' => $this->settings['date_to']
            ]);
            
        //Добавляем условия по выборке товаров
        $q->openWGroup();

        $skip_product_select = false;
        if (!empty($this->settings['products']['group'])) {
            if (!in_array(0, $this->settings['products']['group'])) {
                $q->join(new \Catalog\Model\Orm\Product(), 'P.id = L.oid', 'P')
                  ->whereIn('P.maindir', $this->settings['products']['group']);
            } else {
                $q->where('1');
                $skip_product_select = true;
            }
        }
        
        if (!empty($this->settings['products']['product']) && !$skip_product_select) {
            $q->whereIn('L.oid', $this->settings['products']['product'], 'OR');
        }
            
        $q->closeWGroup();
        
        //Выбираем непосредственно пользователей
        $result = [];
        if ($user_ids = $q->exec()->fetchSelected('user_id', ['product_id'], true)) {
            $users = \Rs\Orm\Request::make()
                ->from(new \Users\Model\Orm\User())
                ->whereIn('id', array_keys($user_ids))
                ->objects();
            
            foreach($users as $user) {
                //Передаем вместе с пользователем еще информацию об ID товаров
                $result[] = new \MailSender\Model\TriggerData($user, [
                    'products' => $user_ids[$user['id']]
                ]);
            }
        }
        
        return $result;
    }
}