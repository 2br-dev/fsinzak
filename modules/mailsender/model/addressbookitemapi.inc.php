<?php
namespace MailSender\Model;

/**
* API для пользователей адресной книги
*/
class AddressBookItemApi extends \RS\Module\AbstractModel\EntityList
{    
    function __construct()
    {
        parent::__construct(new \MailSender\Model\Orm\AddressBookItem(),
            [
                'multisite' => true,
            ]);
    }
}