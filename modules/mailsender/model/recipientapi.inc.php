<?php
namespace MailSender\Model;

/**
* API для получателей писем
*/
class RecipientApi extends \RS\Module\AbstractModel\EntityList
{
    function __construct()
    {
        parent::__construct(new Orm\MailRecipient(), [
            'multisite' => true
        ]);
    }
}