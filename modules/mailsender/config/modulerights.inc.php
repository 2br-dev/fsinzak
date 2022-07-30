<?php
namespace MailSender\Config;

use \RS\AccessControl\Right;
use \RS\AccessControl\RightGroup;

/**
* Объект прав модуля
*/
class ModuleRights extends \RS\AccessControl\DefaultModuleRights
{
    const
        RIGHT_SEND_TEST = 'send_test',
        RIGHT_SEND_TO_ALL = 'send_to_all';
    
    /**
    * Возвращает дерево изначальных прав модуля
    * 
    * @return (Right|RightGroup)[]
    */
    protected function getSelfModuleRights()
    {
        $self_rights = [
            new Right(self::RIGHT_READ, t('Чтение')),
            new Right(self::RIGHT_CREATE, t('Создание')),
            new Right(self::RIGHT_UPDATE, t('Изменение')),
            new Right(self::RIGHT_DELETE, t('Удаление')),
            new Right(self::RIGHT_SEND_TEST, t('Тестовая отправка')),
            new Right(self::RIGHT_SEND_TO_ALL, t('Запуск рассылки')),
        ];
        
        return $self_rights;
    }
}
