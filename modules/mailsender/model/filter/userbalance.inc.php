<?php
namespace MailSender\Model\Filter;
use \RS\Orm\Type,
    \MailSender\Model\Orm\MailRecipient;

/**
* Фильтр по балансу пользователя
*/
class UserBalance extends AbstractFilter
{
    public function getTitle()
    {
        return t('Баланс пользователя');
    }
    
    public function getSettingsObject()
    {
        return new \RS\Orm\FormObject(new \RS\Orm\PropertyIterator([
            'balance_cmp' => new Type\Varchar([
                'description' => t('Тип сравнения'),
                'listFromArray' => [[
                    'lt' => t('менее, чем'),
                    'gt' => t('более, чем'),
                    'eq' => t('равно')
                ]]
            ]),
            'balance' => new Type\Integer([
                'description' => t('Баланс'),
                'checker' => ['ChkEmpty', t('Укажите баланс пользователя')]
            ])
        ]));
    }
    
    public function canSendToRecipient(MailRecipient $recipient)
    {
        if ($recipient->is_system_user) {
            $cmp = ['lt' => '<', 'gt' => '>', 'eq' => '='];
            
            return \RS\Orm\Request::make()
                ->from(new \Users\Model\Orm\User)
                ->where(['id' => $recipient->user_id])
                ->where("balance {$cmp[$this->settings['balance_cmp']]} '#balance_value'", [
                    'balance_value' => $this->settings['balance']
                ])
                ->count() >0;
        }
        
        return true;
    }
}