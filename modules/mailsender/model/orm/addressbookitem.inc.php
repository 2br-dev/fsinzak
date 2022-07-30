<?php

namespace MailSender\Model\Orm;

use RS\Orm\OrmObject;
use \RS\Orm\Type;

/**
 * ORM объект - запись в базе Email адресов
 * --/--
 * @property integer $id Уникальный идентификатор (ID)
 * @property integer $site_id ID сайта
 * @property string $email E-mail получателя
 * @property string $surname Фамилия
 * @property string $name Имя
 * @property string $midname Отчество
 * @property string $company Организация
 * @property integer $group_id Группа
 * --\--
 */
class AddressBookItem extends OrmObject
{
    protected static $table = 'mail_addressbook_item';

    function _init()
    {
        parent::_init()->append([
            'site_id' => new Type\CurrentSite(),
            'email' => new Type\Varchar([
                'description' => t('E-mail получателя'),
                'checker' => ['ChkEmail', t('Неверно указан Email')],
                'trimString' => true,
            ]),
            'surname' => new Type\Varchar([
                'description' => t('Фамилия')
            ]),
            'name' => new Type\Varchar([
                'description' => t('Имя')
            ]),
            'midname' => new Type\Varchar([
                'description' => t('Отчество')
            ]),
            'company' => new Type\Varchar([
                'description' => t('Организация')
            ]),
            'group_id' => new Type\Integer([
                'description' => t('Группа'),
                'tree' => [['\MailSender\Model\AddressBookDirApi', 'staticTreeList'], 0, ['' => t('- Верхний уровень -')]]
            ])
        ]);
    }
}
