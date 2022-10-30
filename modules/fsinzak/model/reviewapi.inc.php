<?php

namespace fsinzak\Model;

use fsinzak\Model\Orm\Review;
use RS\Module\AbstractModel\EntityList;

/**
 * Класс для организации выборок ORM объекта.
 * В этом классе рекомендуется также реализовывать любые дополнительные методы, связанные с заявленной в конструкторе моделью
 */
class ReviewApi extends EntityList
{
    function __construct()
    {
        parent::__construct(new Review());
    }
}
