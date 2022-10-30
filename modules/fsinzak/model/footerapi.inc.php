<?php

namespace fsinzak\Model;

use fsinzak\Model\Orm\Footer;
use RS\Module\AbstractModel\EntityList;

/**
 * Класс для организации выборок ORM объекта.
 * В этом классе рекомендуется также реализовывать любые дополнительные методы, связанные с заявленной в конструкторе моделью
 */
class FooterApi extends EntityList
{
    function __construct()
    {
        parent::__construct(new Footer());
    }
}
