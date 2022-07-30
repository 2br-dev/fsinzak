<?php
namespace MailSender\Config;
use RS\Orm\Type;

/**
* Класс конфигурации модуля
*/
class File extends \RS\Orm\ConfigObject
{
    function _init()
    {
        parent::_init()->append([
            'session_send_limit' => new Type\Integer([
                'description' => t('Ограничение на количество писем, отправленных за один запуск планировщика (1 минуту)'),
            ]),
            'sleep_time_in_seconds' => new Type\Integer([
                'description' => t('Интервал между отправками сообщений (в секундах)'),
                'hint' => t('0 — без задержек'),
            ]),
            'trigger_interval' => new Type\Integer([
                'description' => t('Интервал проверки триггеров'),
                'listFromArray' => [[
                    10 => t('10 минут'),
                    20 => t('20 минут'),
                    60 => t('1 час'),
                    180 => t('3 часа'),
                    1439 => t('24 часа')
                ]]
            ]),
            'css_to_inline' => new Type\Integer([
                'description' => t('Переводить CSS в inline стили в письме'),
                'checkboxView' => [1,0]
            ])
        ]);
    }
    
    function isMultisiteConfig()
    {
        return false;
    }
}