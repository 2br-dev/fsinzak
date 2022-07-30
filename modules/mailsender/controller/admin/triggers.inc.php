<?php
namespace MailSender\Controller\Admin;

use RS\Html\Table\Type as TableType;
use RS\Html\Toolbar\Button as ToolbarButton;
use RS\Html\Filter;
use RS\Html\Table;
use RS\AccessControl\Rights;
use RS\AccessControl\DefaultModuleRights;
    
/**
* Контроллер Управление списком магазинов сети
*/
class Triggers extends \RS\Controller\Admin\Crud
{
    function __construct()
    {
        //Устанавливаем, с каким API будет работать CRUD контроллер
        parent::__construct(new \MailSender\Model\TriggerApi());
    }
    
    function helperIndex()
    {
        $helper = parent::helperIndex(); //Получим helper по-умолчанию
        $helper->setTopTitle(t('Триггеры')); //Установим заголовок раздела
        $helper->setTopHelp(t('Триггер срабатывает при наслуплении определенных событий. Событие настраивается в окне редактирования триггера.'));
        $helper->setTopToolbar($this->buttons(['add'], ['add' => t('Добавить триггер')]));
        
        //Отобразим таблицу со списком объектов
        $helper->setTable(new Table\Element([
            'Columns' => [
                    new TableType\Checkbox('id'),
                    new TableType\Text('title', t('Название'), [
                        'Sortable' => SORTABLE_BOTH, 
                        'href' => $this->router->getAdminPattern('edit', [':id' => '@id']),
                        'LinkAttr' => ['class' => 'crud-edit'
                        ]]),
                    new TableType\Yesno('enabled', t('Включен'), [
                        'toggleUrl' => $this->router->getAdminPattern('ajaxToggleEnabled', [':id' => '@id'])
                    ]),
                    new TableType\Actions('id', [
                            new TableType\Action\Edit($this->router->getAdminPattern('edit', [':id' => '~field~'])),
                            new TableType\Action\DropDown([
                                [
                                    'title' => t('Показать выборку пользователей на текущий момент'),
                                    'attr' => [
                                        '@href' => $this->router->getAdminPattern('showRecipients', [':id' => '@id'])
                                    ]
                                ]
                            ])
                    ],
                        ['SettingsUrl' => $this->router->getAdminUrl('tableOptions')]
                    ),
            ]]));
        
        //Добавим фильтр значений в таблице по названию
        $helper->setFilter(new Filter\Control( [
            'Container' => new Filter\Container( [
                                'Lines' =>  [
                                    new Filter\Line( ['items' => [
                                            new Filter\Type\Text('title', t('Название'), ['SearchType' => '%like%']),
                                    ]
                                    ])
                                ],
            ])
        ]));

        return $helper;
    }
    
    function actionAdd($primaryKey = null, $returnOnSuccess = false, $helper = null)
    {
        if ($primaryKey === null) {
            $types = $this->api->getTriggerTypes();
            $types_keys = array_keys($types);
            if ($first = reset($types_keys)) {
                $this->api->getElement()->type_class = $first;
            }
        }
        
        if ($primaryKey > 0) {
            $this->getHelper()->setTopTitle(t('Редактировать триггер ').'{title}');
        } else {
            $this->getHelper()->setTopTitle(t('Добавить триггер'));
        }        
        
        return parent::actionAdd($primaryKey, $returnOnSuccess, $helper);
    }    
    
    function actionAjaxGetTriggerTypeForm()
    {
        $type = $this->url->request('type', TYPE_STRING);
        if ($type_object = $this->api->getTriggerTypeById($type)) {
            $this->view->assign([
                'type_object' => $type_object,
                'change_type' => true
            ]);
            
            $this->result->setTemplate( 'form/trigger/type_form.tpl' );
        }
        return $this->result;
    }    
    
    function actionAjaxToggleEnabled()
    {
        if ($access_error = Rights::CheckRightError($this, DefaultModuleRights::RIGHT_UPDATE)) {
            return $this->result->addEMessage($access_error)->setSuccess(false);
        }
        
        $id = $this->url->request('id', TYPE_INTEGER);
        $trigger = $this->api->getOneItem($id);
        
        if ($trigger) {
            $trigger['enabled'] = !$trigger['enabled'];
            $trigger->update();
        }
        return $this->result->setSuccess(true);
    }
    
    function actionShowRecipients()
    {
        $id = $this->url->request('id', TYPE_INTEGER);
        if (!$trigger = $this->api->getOneItem($id)) {
            $this->e404(t('Триггер не найден'));
        }
        
        $helper = new \RS\Controller\Admin\Helper\CrudCollection($this);
        $helper->setTopTitle(t('Пользователи по триггеру &laquo;%0&raquo;', [$trigger['title']]));
        $helper->setTopHelp(t('В данном списке отображаются пользователи, кторые на текущий момент времени соответствуют триггеру'));
        $helper->setBottomToolbar(new \RS\Html\Toolbar\Element([
            'Items' => [
                new ToolbarButton\Button($this->url->getSavedUrl($this->controller_name.'index'), t('Назад'))
            ]
        ]));
        $table = new Table\Element([
            'Columns' => [
                new TableType\Text('e_mail', t('Email'), [
                    'href' => $this->router->getAdminPattern('edit', [':id' => '@id'], 'users-ctrl'),
                    'LinkAttr' => ['class' => 'crud-edit']
                ]),
                new TableType\Text('name', t('Имя')),
                new TableType\Text('surname', t('Фамилия')),
                new TableType\Text('midname', t('Отчество')),
                new TableType\Text('company', t('Компания')),
                new TableType\Text('id', t('ID')),
            ]]);
        $table->setData($trigger->getRecipientsArray());
        
        $helper->viewAsTable();
        $helper->setTable($table);
        
        return $this->result->setTemplate( $helper['template'] );
    }
}
