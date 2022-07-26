<?php

namespace fsinzak\Controller\Admin;

use fsinzak\Model\ModelApi;
use fsinzak\Model\RecipientsApi;
use RS\Controller\Admin\Crud;
use RS\Html\Filter;
use RS\Html\Table;
use RS\Html\Table\Type as TableType;
use RS\Html\Toolbar\Button as ToolbarButton;

/**
 * Контроллер Управление списком магазинов сети
 */
class RecipientsCtrl extends Crud
{
    function __construct()
    {
        //Устанавливаем, с каким API будет работать CRUD контроллер
        parent::__construct(new RecipientsApi());
    }

    function helperIndex()
    {
        $helper = parent::helperIndex(); //Получим helper по-умолчанию
        $helper->setTopTitle('Получатели'); //Установим заголовок раздела

        //Отобразим таблицу со списком объектов
        $helper->setTable(new Table\Element([
            'Columns' => [
                new TableType\Checkbox('id', ['ThAttr' => ['width' => 20]]),
                new TableType\Text('surname', 'Фамилия', [
                    'Sortable' => SORTABLE_BOTH,
                    'href' => $this->router->getAdminPattern('edit', [':id' => '@id']),
                    'LinkAttr' => ['class' => 'crud-edit'],
                ]),
                new TableType\Text('name', 'Имя', [
                    'Sortable' => SORTABLE_BOTH,
                    'href' => $this->router->getAdminPattern('edit', [':id' => '@id']),
                    'LinkAttr' => ['class' => 'crud-edit'],
                ]),
                new TableType\Text('midname', 'Отчество', [
                    'Sortable' => SORTABLE_BOTH,
                    'href' => $this->router->getAdminPattern('edit', [':id' => '@id']),
                    'LinkAttr' => ['class' => 'crud-edit'],
                ]),
                new TableType\Userfunc('birthday', t('Дата рождения'), function($value, $field){
                    return '<p>'.date('d.m.Y',strtotime($value)).'</p>';
                }),
                new TableType\Userfunc('user_id', t('Покупатель'), function($value, $field){
                    $user = new \Users\Model\Orm\User($value);
                    return '<p>'.$user->getFio().'('.$user['id'].')</p>';
                }),
                new TableType\StrYesno('removed', t('Удален пользователем')),
                new TableType\Actions('id', [
                    new TableType\Action\Edit($this->router->getAdminPattern('edit', [':id' => '~field~'])),
                ], ['SettingsUrl' => $this->router->getAdminUrl('tableOptions')]),
            ],
        ]));

        //Добавим фильтр значений в таблице по названию
        $helper->setFilter(new Filter\Control([
            'Container' => new Filter\Container([
                'Lines' => [
                    new Filter\Line(['items' => [
                        new Filter\Type\Text('name', 'Имя', ['SearchType' => '%like%']),
                    ]]),
                    new Filter\Line(['items' => [
                        new Filter\Type\Text('midname', 'Отчество', ['SearchType' => '%like%']),
                    ]]),
                    new Filter\Line(['items' => [
                        new Filter\Type\Text('surname', 'Фамилия', ['SearchType' => '%like%']),
                    ]]),
                    new Filter\Line(['items' => [
                        new Filter\Type\Date('birthday', 'Дата рождения'),
                    ]]),
                    new Filter\Line(['items' =>[
                        new Filter\Type\User('user_id', t('Покупатель'))
                    ]]),
                    new Filter\Line(['items' => [
                        new Filter\Type\Select('removed', t('Удален пользователем'), [
                            '' => t('Не важно'),
                            0 => t('Нет'),
                            1 => t('Да'),
                        ]),
                    ]]),
                ],
            ]),
        ]));

        return $helper;
    }
}
