<?php
namespace MailSender\Controller\Admin;

use \RS\Html\Table\Type as TableType,
    \RS\Html\Toolbar\Button as ToolbarButton,
    \RS\Html\Filter,
    \RS\Html\Table;
    
/**
* Контроллер Управление списком магазинов сети
*/
class Logs extends \RS\Controller\Admin\Crud
{
    function __construct()
    {
        //Устанавливаем, с каким API будет работать CRUD контроллер
        parent::__construct(new \MailSender\Model\RecipientApi());
    }
    
    function helperIndex()
    {
        $helper = parent::helperIndex(); //Получим helper по-умолчанию
        $helper->setTopTitle(t('Журнал отправки')); //Установим заголовок раздела
        $helper->setTopHelp(t('Журнал рассылки показывает получателей, которым было отправлено письмо. Данные записи используются системой, для предотвращения повторной отправки письма одному и тому же получателю.'));
        $helper->setTopToolbar(new \RS\Html\Toolbar\Element([
            'Items' => [
                new ToolbarButton\Button(\RS\Router\Manager::obj()->getAdminUrl('exportCsv', ['schema' => 'mailsender-recipient', 'referer' => $this->url->selfUri()], 'main-csv'), t('Экспорт CSV'), [
                    'attr' => [
                        'class' => 'crud-add'
                    ]
                ])
            ]
        ]));
        
        //Отобразим таблицу со списком объектов
        $helper->setTable(new Table\Element([
            'Columns' => [
                    new TableType\Checkbox('id', ['showSelectAll' => true]),
                    new TableType\Text('template_id', t('Шаблон отправки'), [
                        'Sortable' => SORTABLE_BOTH,
                    ]),
                    new TableType\Text('email', t('E-mail'), [
                        'Sortable' => SORTABLE_BOTH,
                    ]),
                    new TableType\Text('name', t('Имя'), [
                        'Sortable' => SORTABLE_BOTH,
                    ]),
                    new TableType\Text('surname', t('Фамилия'), [
                        'Sortable' => SORTABLE_BOTH,
                    ]),
                    new TableType\Text('middle_name', t('Отчество'), [
                        'Sortable' => SORTABLE_BOTH,
                    ]),
                    new TableType\Text('company', t('Компания'), [
                        'Sortable' => SORTABLE_BOTH,
                    ]),
                    new TableType\Text('groups', t('Группы'), [
                        'Sortable' => SORTABLE_BOTH, 
                        'hidden' => true
                    ]),
                    new TableType\Datetime('dateof', t('Дата отправки'), [
                        'Sortable' => SORTABLE_BOTH,
                    ]),
                    new TableType\Text('user_id', t('ID Пользователя'), [
                        'href' => $this->router->getAdminPattern('edit', [':id' => '@user_id'], 'users-ctrl'),
                        'linkAttr' => [
                            'class' => 'crud-edit'
                        ]
                    ]),
                    new TableType\StrYesno('is_sended', t('Отправлен'), [
                        'Sortable' => SORTABLE_BOTH,
                    ]),
                    new TableType\Actions('id', [], ['SettingsUrl' => $this->router->getAdminUrl('tableOptions')]),
            ]]));
        
        //Добавим фильтр значений в таблице
        $helper->setFilter(new Filter\Control( [
            'Container' => new Filter\Container( [
                                'Lines' =>  [
                                    new Filter\Line( ['items' => [
                                            new Filter\Type\Text('email', t('E-mail'), ['SearchType' => '%like%']),
                                            new Filter\Type\User('user_id', t('Пользователь')),
                                            new Filter\Type\Select('template_id', t('Шаблон рассылки'), ['' => t('Любой')] + \MailSender\Model\TemplateApi::staticSelectList()),
                                            new Filter\Type\DateRange('dateof', t('Дата отправки'))
                                    ]
                                    ])
                                ],
                                'SecContainers' => [
                                    new Filter\Seccontainer([
                                        'Lines' => [
                                            new Filter\Line( [
                                                'Items' => [
                                                    new Filter\Type\Text('name', t('Имя'), ['SearchType' => '%like%']),
                                                    new Filter\Type\Text('surname', t('Фамилия'), ['SearchType' => '%like%']),
                                                    new Filter\Type\Text('middle_name', t('Отчество'), ['SearchType' => '%like%']),
                                                    new Filter\Type\Text('company', t('Компания'), ['SearchType' => '%like%']),
                                                    new Filter\Type\Select('is_sended', t('Отправлен'), ['' => t('не важно'), '1' => t('Да'), '0' => t('Нет')]),
                                                ]
                                            ])
                                        ]
                                    ])
                                ]
            ])
        ]));

        return $helper;
    }
}
