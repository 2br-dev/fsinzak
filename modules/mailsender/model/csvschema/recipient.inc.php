<?php
namespace MailSender\Model\CsvSchema;
use MailSender\Model\RecipientApi;
use \RS\Csv\Preset,
    \MailSender\Model\Orm;

/**
* Схема экспорта/импорта характеристик в CSV
*/
class Recipient extends \RS\Csv\AbstractSchema
{
    function __construct()
    {
        parent::__construct(new Preset\Base([
            'ormObject' => new Orm\MailRecipient(),
            'excludeFields' => ['id', 'site_id', '_user_extra'],
            'multisite' => true,
            'searchFields' => ['email'],
            'savedRequest' => RecipientApi::getSavedRequest('MailSender\Controller\Admin\Logs_list'), //Объект запроса из сессии с параметрами текущего просмотра списка
        ]));
    }
    
}