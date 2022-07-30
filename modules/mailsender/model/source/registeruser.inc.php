<?php
namespace MailSender\Model\Source;

/**
* Источник получателей рассылки - зарегистрированные пользователи
*/
class RegisterUser extends AbstractSource
{
    /**
    * Возвращает название источника получателей
    * 
    * @return string
    */
    public function getTitle()
    {
        return t('Зарегистрированные пользователи');
    }
    
    /**
    * Возвращает описание источника получателей
    * 
    * @return string
    */
    public function getDescription()
    {
        return t('Возвращает полный список зарегистрированных в системе пользователей');
    }
    
    /**
    * Возвращает список объектов получателей
    * 
    * @return MailSender\Model\Orm\MailRecipient[]
    */
    public function getRecipients()
    {
        $offset = 0;
        $page_size = 100;
        $q = \RS\Orm\Request::make()
            ->from(new \Users\Model\Orm\User())            
            ->limit($page_size);

        $recipients = [];
        while($users = $q->offset($offset)->objects()) {
            foreach($users as $user) {
                $recipient = new \MailSender\Model\Orm\MailRecipient();
                $recipient->makeFromUser($user, $this);
                
                $recipients[$recipient->email] = $recipient;
            }
            $offset += $page_size;
        }
        return $recipients;
    }
}
