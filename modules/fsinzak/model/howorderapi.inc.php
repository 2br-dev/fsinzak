<?php

namespace fsinzak\Model;

use fsinzak\Model\Orm\HowOrder;
use RS\Module\AbstractModel\EntityList;

/**
 * Класс для организации выборок ORM объекта.
 * В этом классе рекомендуется также реализовывать любые дополнительные методы, связанные с заявленной в конструкторе моделью
 */
class HowOrderApi extends EntityList
{
    function __construct()
    {
        parent::__construct(new HowOrder());
    }
}
