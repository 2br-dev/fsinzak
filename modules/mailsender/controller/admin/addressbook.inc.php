<?php
namespace MailSender\Controller\Admin;

use MailSender\Model\AddressBookDirApi;
use MailSender\Model\AddressBookItemApi;
use RS\Application\Application;
use RS\Controller\Admin\Crud;
use RS\Html\Table\Type as TableType;
use RS\Html\Toolbar\Button as ToolbarButton;
use RS\Html\Toolbar;
use RS\Html\Tree;
use RS\Html\Filter;
use RS\Html\Table;

class AddressBook extends Crud
{
    /** @var AddressBookItemApi */
    protected $api;
    protected $dir;

    function __construct()
    {
        parent::__construct(new AddressBookItemApi());
        $this->setTreeApi(new AddressBookDirApi(), t('группу пользователей'));
    }

    function actionIndex()
    {
        //Если категории не существует, то выбираем пункт "Все"
        if ($this->dir > 0 && !$this->getTreeApi()->getById($this->dir)) $this->dir = 0;
        if ($this->dir > 0) $this->api->setFilter('group_id', $this->dir);
        return parent::actionIndex();
    }

    function helperIndex()
    {
        $collection = parent::helperIndex();

        $this->dir = $this->url->request('dir', TYPE_STRING);

        $collection->setTopTitle(t('Адресная книга'));
        $collection->setTopHelp(t('В данном разделе можно заводить произвольных получателей вашей рассылки, распределенных по группам'));
        //Параметры таблицы
        $collection->setTopToolbar(new Toolbar\Element([
                'Items' => [
                    new ToolbarButton\Dropdown([
                        [
                            'title' => t('добавить пользователя'),
                            'attr' => [
                                'href' => $this->router->getAdminUrl('add', ['dir' => $this->dir]),
                                'class' => 'btn-success crud-add'
                            ]
                        ],
                        [
                            'title' => t('добавить группу пользователей'),
                            'attr' => [
                                'href' => $this->router->getAdminUrl('treeAdd'),
                                'class' => 'crud-add'
                            ]
                        ]
                    ]),
                ]]
        ));
        $collection->addCsvButton('mailsender-addressbook');
        $collection->setTable(new Table\Element([
            'Columns' => [
                new TableType\Checkbox('id', ['showSelectAll' => true]),
                new TableType\Text('email', t('E-mail'), ['href' => $this->router->getAdminPattern('edit', [':id' => '@id']), 'LinkAttr' => ['class' => 'crud-edit'], 'Sortable' => SORTABLE_BOTH]),
                new TableType\Text('name', t('Имя')),
                new TableType\Text('surname', t('Фамилия'), ['Sortable' => SORTABLE_BOTH]),
                new TableType\Text('midname', t('Отчество'), ['Sortable' => SORTABLE_BOTH]),
                new TableType\Text('company', t('Организация'), ['Sortable' => SORTABLE_BOTH]),

                new TableType\Text('id', '№', ['ThAttr' => ['width' => '50'], 'TdAttr' => ['class' => 'cell-sgray'], 'Sortable' => SORTABLE_BOTH, 'CurrentSort' => SORTABLE_DESC]),
                new TableType\Actions('id', [
                    new TableType\Action\Edit($this->router->getAdminPattern('edit', [':id' => '~field~']), null, [
                        'attr' => [
                            '@data-id' => '@id'
                        ]
                    ]),
                ], ['SettingsUrl' => $this->router->getAdminUrl('tableOptions')]),
            ]
        ]));

        //Параметры фильтра
        $collection->setFilter(new Filter\Control([
            'Container' => new Filter\Container([
                'Lines' => [
                    new Filter\Line(['items' => [
                        new Filter\Type\Text('id', '№', ['Attr' => ['size' => 4]]),
                        new Filter\Type\Text('email', t('E-mail'), ['SearchType' => '%like%']),
                        new Filter\Type\Text('name', t('Имя'), ['SearchType' => '%like%']),
                        new Filter\Type\Text('surname', t('Фамилия'), ['SearchType' => '%like%']),
                        new Filter\Type\Text('midname', t('Отчество'), ['SearchType' => '%like%']),
                    ]])
                ],
                'SecContainers' => [
                    new Filter\Seccontainer([
                        'Lines' => [
                            new Filter\Line(['items' => [
                                new Filter\Type\Text('company', t('Организация'), ['SearchType' => '%like%']),
                            ]])
                        ]
                    ])
                ]
            ]),
            'ToAllItems' => ['FieldPrefix' => $this->api->defAlias()]
        ]));

        $collection->setTree(new Tree\Element([
            'sortIdField' => 'id',
            'activeField' => 'id',
            'activeValue' => $this->dir,
            'pathToFirst' => $this->getTreeApi()->getPathToFirst($this->dir),
            'rootItem' => [
                'noOtherColumns' => true,
                'noCheckbox' => true,
                'noDraggable' => true,
                'noFullValue' => true,
                'title' => t('Все'),
                'id' => 0,
                'alias' => ''
            ],
            'sortable' => false,
            'mainColumn' => new TableType\Text('title', t('Название'), ['href' => $this->router->getAdminPattern(false, [':dir' => '@id'])]),
            'tools' => new TableType\Actions('id', [
                new TableType\Action\Edit($this->router->getAdminPattern('treeEdit', [':id' => '~field~']), null, [
                    'attr' => [
                        '@data-id' => '@id'
                    ]
                ]),
                new TableType\Action\DropDown([
                    [
                        'title' => t('добавить дочернюю группу'),
                        'attr' => [
                            '@href' => $this->router->getAdminPattern('treeAdd', [':pid' => '~field~']),
                            'class' => 'crud-add'
                        ]
                    ]
                ])
            ]),
            'headButtons' => [
                [
                    'attr' => [
                        'title' => t('Создать группу'),
                        'href' => $this->router->getAdminUrl('TreeAdd'),
                        'class' => 'add crud-add'
                    ]
                ]
            ],
        ]), $this->getTreeApi());

        $collection->setTreeBottomToolbar(new Toolbar\Element([
            'Items' => [
                new ToolbarButton\Multiedit($this->router->getAdminUrl('treeMultiEdit')),
                new ToolbarButton\Delete(null, null, ['attr' =>
                    ['data-url' => $this->router->getAdminUrl('treeDel')]
                ]),
            ]
        ]));

        $collection->setBottomToolbar($this->buttons(['multiedit', 'delete']));
        $collection->viewAsTableTree();
        return $collection;
    }

    function actionAdd($primaryKey = null, $returnOnSuccess = false, $helper = null)
    {
        $parent = $this->url->request('dir', TYPE_INTEGER);
        $obj = $this->api->getElement();

        if ($primaryKey === null) {
            if ($parent) {
                $obj['parent_id'] = $parent;
            }
        }

        $this->getHelper()->setTopTitle($primaryKey ? t('Редактировать пользователя') : t('Добавить пользователя'));
        return parent::actionAdd($primaryKey, $returnOnSuccess, $helper);
    }

    function actionTreeAdd($primaryKey = null)
    {
        if ($primaryKey === null) {
            $pid = $this->url->request('pid', TYPE_STRING, '');
            $this->getTreeApi()->getElement()->offsetSet('parent_id', $pid);
        }

        return parent::actionTreeAdd($primaryKey);
    }
}
