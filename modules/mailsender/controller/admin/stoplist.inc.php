<?php
namespace MailSender\Controller\Admin;

use \RS\Html\Table\Type as TableType,
    \RS\Html\Toolbar\Button as ToolbarButton,
    \RS\Html\Filter,
    \RS\Html\Table;
    
/**
* Контроллер Управление списком магазинов сети
*/
class StopList extends \RS\Controller\Admin\Crud
{
    function __construct()
    {
        //Устанавливаем, с каким API будет работать CRUD контроллер
        parent::__construct(new \MailSender\Model\StopListApi());
    }
    
    function helperIndex()
    {
        $helper = parent::helperIndex(); //Получим helper по-умолчанию
        $helper->setTopTitle(t('Исключенные получатели')); //Установим заголовок раздела
        $helper->setTopHelp(t('Указанные в данном списке email адреса будут исключены из списка получателей рассылок. Адреса добавляются сюда автоматически после перехода по адресу отписки от рассылки.'));
        $helper->setTopToolbar($this->buttons(['add'], ['add' => t('Добавить Email')]));
        $helper->addCsvButton('mailsender-stoplist');
        
        //Отобразим таблицу со списком объектов
        $helper->setTable(new Table\Element([
            'Columns' => [
                    new TableType\Checkbox('id', ['showSelectAll' => true]),
                    new TableType\Text('email', t('Получатель'), [
                        'Sortable' => SORTABLE_BOTH, 
                        'href' => $this->router->getAdminPattern('edit', [':id' => '@id']),
                        'LinkAttr' => ['class' => 'crud-edit'
                        ]]),
                    new TableType\Datetime('dateof', t('Дата'), [
                        'Sortable' => SORTABLE_BOTH,
                    ]),
                    new TableType\Actions('id', [
                            new TableType\Action\Edit($this->router->getAdminPattern('edit', [':id' => '~field~'])),
                    ],
                        ['SettingsUrl' => $this->router->getAdminUrl('tableOptions')]
                    ),
            ]]));
        
        //Добавим фильтр значений в таблице
        $helper->setFilter(new Filter\Control( [
            'Container' => new Filter\Container( [
                                'Lines' =>  [
                                    new Filter\Line( ['items' => [
                                            new Filter\Type\Text('email', t('E-mail'), ['SearchType' => '%like%']),
                                            new Filter\Type\DateRange('dateof', t('Дата внесения'))
                                    ]
                                    ])
                                ],
            ])
        ]));

        return $helper;
    }
}
