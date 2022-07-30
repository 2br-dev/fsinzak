<?php
namespace MailSender\Model\Filter;
use \RS\Orm\Type,
    \MailSender\Model\Orm\MailRecipient;

class UserGroup extends AbstractFilter
{
    public function getTitle()
    {
        return t('Группа зарегистрированного пользователя');
    }
    
    public function getSettingsObject()
    {
        return new \RS\Orm\FormObject(new \RS\Orm\PropertyIterator([
            'groups' => new Type\ArrayList([
                'description' => t('Группа пользователя'),
                'list' => [['\Users\Model\GroupApi', 'staticSelectList']],
                'Attr' => [['size' => 5, 'multiple' => 'multiple']],
                'checker' => ['chkEmpty', t('Укажите группы пользователей')]
            ])
        ]));
    }
    
    public function canSendToRecipient(MailRecipient $recipient)
    {
        if ($recipient->is_system_user) {
            return count(array_intersect(explode(',',$recipient->groups), $this->settings['groups']));
        }
        return true;
    }
}
