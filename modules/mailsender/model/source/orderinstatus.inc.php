<?php

namespace MailSender\Model\Source;

use RS\Module\AbstractModel\TreeList\AbstractTreeListIterator;
use RS\Orm\Type;

/**
 * Источник получателей рассылки - зарегистрированные пользователи
 */
class OrderInStatus extends AbstractSource
{
    /**
     * Возвращает название источника получателей
     *
     * @return string
     */
    public function getTitle()
    {
        return t('Есть заказ в указанном статусе');
    }

    /**
     * Возвращает описание источника получателей
     *
     * @return string
     */
    public function getDescription()
    {
        return t('Возвращает список пользователей, у которых есть оформленный заказ в указанном статусе');
    }

    /**
     * Возврашает объект с настройками источника
     *
     * @return \RS\Orm\FormObject | null
     */
    function getSettingsObject()
    {
        return new \RS\Orm\FormObject(new \RS\Orm\PropertyIterator([
            'order_status' => new Type\ArrayList([
                'runtime' => false,
                'description' => t('Статусы заказов'),
                'list' => [['\Shop\Model\UserStatusApi', 'staticSelectList']],
                'attr' => [[
                    AbstractTreeListIterator::ATTRIBUTE_MULTIPLE => true,
                ]],
                'checker' => ['ChkEmpty', t('Не указаны статусы заказов')]
            ]),
        ]));
    }

    /**
     * Возвращает список объектов получателей
     *
     * @return MailSender\Model\Orm\MailRecipient[]
     * @throws \RS\Orm\Exception
     */
    public function getRecipients()
    {
        $offset = 0;
        $page_size = 100;
        $q = \RS\Orm\Request::make()
            ->from(new \Users\Model\Orm\User(), 'U')
            ->join(new \Shop\Model\Orm\Order(), 'U.id = O.user_id', 'O')
            ->whereIn('O.status', $this->settings['order_status'])
            ->groupby('U.id')
            ->limit($page_size);

        $recipients = [];
        while ($users = $q->offset($offset)->objects()) {
            foreach ($users as $user) {
                $recipient = new \MailSender\Model\Orm\MailRecipient();
                $recipient->makeFromUser($user, $this);

                $recipients[$recipient->email] = $recipient;
            }
            $offset += $page_size;
        }
        return $recipients;
    }
}
