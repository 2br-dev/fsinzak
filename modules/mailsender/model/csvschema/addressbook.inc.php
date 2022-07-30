<?php
namespace MailSender\Model\CsvSchema;
use MailSender\Model\AddressBookItemApi;
use \RS\Csv\Preset,
    \MailSender\Model\Orm;

/**
* Схема экспорта/импорта характеристик в CSV
*/
class AddressBook extends \RS\Csv\AbstractSchema
{
    function __construct()
    {
        parent::__construct(new Preset\Base([
            'ormObject' => new Orm\AddressBookItem(),
            'temporaryId' => true,
            'excludeFields' => ['id', 'site_id', 'group_id'],
            'multisite' => true,
            'searchFields' => ['email', 'group_id'],
            'savedRequest' => AddressBookItemApi::getSavedRequest('MailSender\Controller\Admin\AddressBook_list'), //Объект запроса из сессии с параметрами текущего просмотра списка
        ]),
        [
            new Preset\TreeParent([
                'ormObject' => new Orm\AddressBookDir(),                
                'titles' => [
                    'title' => t('Группа'),
                ],
                'idField' => 'id',
                'parentField' => 'parent_id',
                'treeField' => 'title',
                'rootValue' => 0,
                'multisite' => true,
                'linkForeignField' => 'group_id',
                'linkPresetId' => 0
            ])
        ]);
    }
    
}