<?php

namespace fsinzak\Model\Orm;

use RS\Orm\OrmObject;
use RS\Orm\Type;

/**
 * ORM объект
 */
class HowOrder extends OrmObject
{
    protected static $table = 'howorder';

    function _init()
    {
        parent::_init()->append([
            'number' => new Type\Integer([
                'description' => t('Порядковый номер'),
            ]),
            'text' => new Type\Text([
                'description' => t('Текст')
            ]),
            'image' => new Type\Image([
                'max_file_size' => 10000000,
                'allow_file_types' => ['image/pjpeg', 'image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'],
                'description' => t('Изображение'),
                'specVisible' => true,
                'rootVisible' => false
            ]),
            'public' => new Type\Integer([
                'description' => t('Отображать на сайте'),
                'CheckBoxView' => [1,0],
                'default' => 1
            ])
        ]);
    }
}
