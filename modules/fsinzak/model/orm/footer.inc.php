<?php

namespace fsinzak\Model\Orm;

use RS\Orm\OrmObject;
use RS\Orm\Type;

/**
 * ORM объект
 */
class Footer extends OrmObject
{
    protected static $table = 'footer';

    function _init()
    {
        parent::_init()->append([
            t('Основное'),
                'important_information' => new Type\Richtext([
                    'description' => t('Важная информация'),
                ]),
                'help_to_order' => new Type\Richtext([
                    'description' => t('Текст')
                ]),
                'main_phone' => new Type\Text([
                    'description' => t('Основной телефон')
                ]),
                'e_mail' => new Type\Text([
                    'description' => t('E-mail')
                ]),
                'regim' => new Type\Richtext([
                    'description' => t('Режим работы')
                ]),
            t('Дополнительные контакты'),
                'dop_contacts' => new Type\Richtext([
                    'description' => t('Текст')
                ])
        ]);
    }

    public function getMainPhoneLink()
    {
        $phone_link = str_replace('-','', $this['main_phone']);
        return $phone_link;
    }
}
