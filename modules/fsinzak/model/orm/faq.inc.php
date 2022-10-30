<?php

namespace fsinzak\Model\Orm;

use RS\Orm\OrmObject;
use RS\Orm\Type;

/**
 * ORM объект
 */
class Faq extends OrmObject
{
    protected static $table = 'faq';

    function _init()
    {
        parent::_init()->append([
            'title' => new Type\Varchar([
                'description' => t('Заголовок'),
            ]),
            'text' => new Type\Richtext([
                'description' => t('Текст')
            ]),
            'public' => new Type\Integer([
                'description' => t('Отображать на сайте'),
                'maxLength' => 1,
                'default' => 1,
                'CheckBoxView' => [1,0]
            ]),
            'created' => new Type\Date([
                'description' => t('Дата создания'),
                'visible' => false
            ]),
            'updated' => new Type\Date([
                'description' => t('Дата обновления'),
                'visible' => false
            ])
        ]);
    }

    /**
     * При создании записи
     */
    function beforeWrite($flag)
    {
        if ($flag == self::INSERT_FLAG) {
            $this['created'] = date('Y-m-d');
            $this['updated'] = date('Y-m-d');
        }
        if($flag == self::UPDATE_FLAG){
            $this['updated'] = date('Y-m-d');
        }
    }
}
