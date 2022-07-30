<?php

namespace MailSender\Model;

use MailSender\Model\Orm\AddressBookDir;
use RS\Module\AbstractModel\TreeCookieList;

/**
 * API для групп пользователей адресной книги
 */
class AddressBookDirApi extends TreeCookieList
{
    function __construct()
    {
        parent::__construct(new AddressBookDir(), [
            'parentField' => 'parent_id',
            'multisite' => true,
            'idField' => 'id',
            'nameField' => 'title',
        ]);
    }

    /**
     * @deprecated (19.03)
     * Возвращает список групп получателей в виде плоского списка
     *
     * @param bool $include_root - если true, то включать корневой элемент
     * @return array
     * @throws \RS\Db\Exception
     */
    static function selectList($include_root = true)
    {
        $_this = self::getInstance();
        $list = $_this->getSelectList(0);
        return $include_root ? ['' => t('Верхний уровень')] + $list : $list;
    }
}
