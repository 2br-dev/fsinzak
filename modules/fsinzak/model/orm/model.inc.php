<?php

namespace fsinzak\Model\Orm;

use RS\Orm\OrmObject;
use RS\Orm\Type;

/**
 * ORM объект
 */
class Model extends OrmObject
{
    protected static $table = 'testmodule_fsinzak';

    function _init()
    {
        parent::_init()->append([
            'title' => new Type\Varchar([
                'description' => t('Название'),
            ])
        ]);
    }
}
