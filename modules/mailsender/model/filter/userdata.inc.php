<?php
namespace MailSender\Model\Filter;
use \RS\Orm\Type,
    \MailSender\Model\Orm\MailRecipient;

class UserData extends AbstractFilter
{
    public function getTitle()
    {
        return t('Данные пользователя');
    }
    
    public function getSettingsObject()
    {
        $hint = t('Оставьте пустое поле, чтобы не фильтровать по параметру');
        return new \RS\Orm\FormObject(new \RS\Orm\PropertyIterator([
            'email' => new Type\Varchar([
                'description' => t('E-mail'),                
                'hint' => $hint
            ]),
            'name' => new Type\Varchar([
                'description' => t('Имя'),
                'hint' => $hint
            ]),
            'surname' => new Type\Varchar([
                'description' => t('Фамилия'),
                'hint' => $hint
            ]),
            'middle_name' => new Type\Varchar([
                'description' => t('Отчество'),
                'hint' => $hint
            ]),
            'company' => new Type\Varchar([
                'description' => t('Наименование компании'),
                'hint' => $hint
            ])
        ]));
    }
    
    public function canSendToRecipient(MailRecipient $recipient)
    {
        return $this->check($recipient, 'email')
                && $this->check($recipient, 'name')
                && $this->check($recipient, 'surname')
                && $this->check($recipient, 'middle_name')
                && $this->check($recipient, 'company');
    }
    
    private function check($recipient, $field)
    {
        if (isset($this->settings[$field]) && $this->settings[$field] != '') {
            return $recipient->$field == $this->settings[$field];
        }
        return true;
    }
}