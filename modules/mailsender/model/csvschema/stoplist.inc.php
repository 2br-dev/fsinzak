<?php
namespace MailSender\Model\CsvSchema;
use MailSender\Model\StopListApi;
use \RS\Csv\Preset,
    \MailSender\Model\Orm;

/**
* Схема экспорта/импорта характеристик в CSV
*/
class StopList extends \RS\Csv\AbstractSchema
{
    function __construct()
    {
        parent::__construct(new Preset\Base([
            'ormObject' => new Orm\StopList(),
            'excludeFields' => ['id', 'site_id'],
            'multisite' => true,
            'searchFields' => ['email'],
            'savedRequest' => StopListApi::getSavedRequest('MailSender\Controller\Admin\StopList_list'), //Объект запроса из сессии с параметрами текущего просмотра списка
        ]));
    }
    
}