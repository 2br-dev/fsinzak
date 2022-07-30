<?php
namespace MailSender\Model\Source;

/**
* Источник получателей рассылки - зарегистрированные пользователи
*/
class AddressBook extends AbstractSource
{
    /**
    * Возвращает название источника получателей
    * 
    * @return string
    */
    public function getTitle()
    {
        return t('Пользователи из адресной книги');
    }
    
    /**
    * Возвращает описание источника получателей
    * 
    * @return string
    */
    public function getDescription()
    {
        return t('Возвращает полный список пользователей, заведенных в адресной книге');
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
            ->from(new \MailSender\Model\Orm\AddressBookItem())
            ->where([
                'site_id' => $this->template['site_id']
            ])
            ->limit($page_size);

        $recipients = [];
        while($users = $q->offset($offset)->objects()) {
            foreach($users as $user) {
                if (isset($recipients[$user['email']])) {
                    $recipients[$user['email']]->groups .= ','.$user['group_id'];
                } else {
                    $recipient = new \MailSender\Model\Orm\MailRecipient();
                    $recipient->source_class = get_class($this);
                    $recipient->email = $user['email'];
                    $recipient->name = $user['name'];
                    $recipient->surname = $user['surname'];
                    $recipient->middle_name = $user['midname'];
                    $recipient->user_id = $user['id'];
                    $recipient->groups = $user['group_id'];
                    $recipients[$recipient->email] = $recipient;
                }
            }
            $offset += $page_size;
        }
        return $recipients;
    }
}