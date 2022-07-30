<?php
namespace MailSender\Model\Source;

/**
* Пользователи, на которых оформлены заказы
*/
class Buyers extends AbstractSource
{
    /**
    * Возвращает название источника получателей
    * 
    * @return string
    */
    public function getTitle()
    {
        return t('Покупатели');
    }
    
    /**
    * Возвращает описание источника получателей
    * 
    * @return string
    */
    public function getDescription()
    {
        return t('Возвращает список пользователей, которые хоть раз совершали покупку');
    }
    
    /**
    * Возвращает список объектов получателей
    * 
    * @return MailSender\Model\Orm\MailRecipient[]
    */
    public function getRecipients()
    {
        $recipients = [];
        if (\RS\Module\Manager::staticModuleExists('shop')) {
            $offset = 0;
            $page_size = 100;
            $q = \RS\Orm\Request::make()
                ->from(new \Users\Model\Orm\User(), 'U')
                ->join(new \Shop\Model\Orm\Order(), 'O.user_id=U.id', 'O')
                ->where([
                    'O.site_id' => \RS\Site\Manager::getSiteId()
                ])
                ->groupby('U.id')
                ->limit($page_size);

            while($users = $q->offset($offset)->objects()) {
                foreach($users as $user) {
                    $recipient = new \MailSender\Model\Orm\MailRecipient();
                    $recipient->makeFromUser($user, $this);
                    
                    $recipients[$recipient->email] = $recipient;
                }
                $offset += $page_size;
            }
        }
        return $recipients;
    }
    
}
