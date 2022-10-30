<?php

namespace fsinzak\Controller\Admin;

use fsinzak\Model\HowOrderApi;
use fsinzak\Model\ModelApi;
use RS\Controller\Admin\Crud;
use RS\Html\Filter;
use RS\Html\Table;
use RS\Html\Table\Type as TableType;
use RS\Html\Toolbar\Button as ToolbarButton;

/**
 * Контроллер Управление списком магазинов сети
 */
class HowOrderCtrl extends Crud
{
    function __construct()
    {
        //Устанавливаем, с каким API будет работать CRUD контроллер
        parent::__construct(new HowOrderApi());
    }

    function helperIndex()
    {
        $helper = parent::helperIndex(); //Получим helper по-умолчанию
        $helper->setTopTitle('Блок текста на главной странице - Как заказать?'); //Установим заголовок раздела

        //Отобразим таблицу со списком объектов
        $helper->setTable(new Table\Element([
            'Columns' => [
                new TableType\Checkbox('id', ['ThAttr' => ['width' => 20]]),
                new TableType\Text('number', 'Номер', [
                    'Sortable' => SORTABLE_BOTH,
                    'href' => $this->router->getAdminPattern('edit', [':id' => '@id']),
                    'LinkAttr' => ['class' => 'crud-edit'],
                ]),
                new TableType\Text('text', 'Текст'),
                new TableType\UserFunc('public', t('Отображать'), function($value, $field) {
                    $howorder = $field->getRow();
                    if ($howorder['public']) {
                        $switch = 'on';
                    } else {
                        $switch = '';
                    }
                    return '<div class="toggle-switch rs-switch crud-switch ' . $switch . '" data-url="/admin/fsinzak-tools/?id=' . $howorder['id'] . '&do=AjaxToggleHowOrderPublic">
                                <label class="ts-helper"></label>
                            </div>';
                }),
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
                        new Filter\Type\Text('title', 'Название', ['SearchType' => '%like%']),
                    ]]),
                ],
            ]),
        ]));

        return $helper;
    }
}
