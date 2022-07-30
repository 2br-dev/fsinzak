<?php

namespace MailSender\Model\Orm;

use RS\Orm\OrmObject;
use RS\Orm\Request as OrmRequest;
use \RS\Orm\Type;

/**
 * ORM объект - группа адресов
 * --/--
 * @property integer $id Уникальный идентификатор (ID)
 * @property integer $site_id ID сайта
 * @property string $title Наименование
 * @property integer $parent_id Родитель
 * --\--
 */
class AddressBookDir extends OrmObject
{
    protected static
        $table = 'mail_addressbook_dir';

    function _init()
    {
        parent::_init()->append([
            'site_id' => new Type\CurrentSite(),
            'title' => new Type\Varchar([
                'description' => t('Наименование'),
            ]),
            'parent_id' => new Type\Integer([
                'description' => t('Родитель'),
                'tree' => [['\MailSender\Model\AddressBookDirApi', 'staticTreeList'], 0, ['' => t('- Верхний уровень -')]]
            ])
        ]);
    }

    /**
     * Удаляет объект из хранилища
     *
     * @return boolean - true, в случае успеха
     * @throws \RS\Db\Exception
     */
    function delete()
    {
        if ($result = parent::delete()) {
            OrmRequest::make()
                ->delete()
                ->from(new AddressBookItem())
                ->where([
                    'group_id' => $this['id']
                ])->exec();
        }

        return $result;
    }
}
