<?php
namespace MailSender\Model\Source;

use MailSender\Model\Orm\MailRecipient;
use RS\Db\Exception as DbException;
use RS\Exception as RSException;
use RS\Module\Manager as ModuleManager;
use RS\Orm\Exception as OrmException;
use RS\Orm\FormObject;
use RS\Orm\PropertyIterator;
use RS\Orm\Request as OrmRequest;
use RS\Orm\Type;
use Shop\Model\Orm\Order;
use Users\Model\Orm\User;

/**
* Пользователи с указанным менеджером
*/
class UserWithManager extends AbstractSource
{
    /**
    * Возвращает название источника получателей
    * 
    * @return string
    */
    public function getTitle()
    {
        return t('Пользователи с указанным менеджером');
    }
    
    /**
    * Возвращает описание источника получателей
    * 
    * @return string
    */
    public function getDescription()
    {
        return t('Возвращает список пользователей, у которых указан менеджер из выбранного списка');
    }

    /**
     * Возврашает объект с настройками источника
     *
     * @return FormObject
     */
    function getSettingsObject()
    {
        return new FormObject(new PropertyIterator([
            'managers' => new Type\ArrayList([
                'runtime' => false,
                'description' => t('Список менеджеров'),
                'list' => [['\Shop\Model\OrderApi', 'getUsersManagersName'], [0 => t('- Любой менеджер -')]],
                'attr' => [[
                    'multiple' => true,
                ]],
            ]),
        ]));
    }

    /**
     * Возвращает список объектов получателей
     *
     * @return MailRecipient[]
     * @throws DbException
     * @throws RSException
     * @throws OrmException
     */
    public function getRecipients()
    {
        $recipients = [];
        if (ModuleManager::staticModuleExists('shop')) {
            $offset = 0;
            $page_size = 100;
            $all_managers = (empty($this->settings['managers']) || in_array(0, $this->settings['managers']));
            $q = OrmRequest::make()
                ->from(new User())
                ->groupby('id')
                ->limit($page_size);

            if ($all_managers) {
                $q->where('manager_user_id > ""');
            } else {
                $q->whereIn('manager_user_id', $this->settings['managers']);
            }

            while($users = $q->offset($offset)->objects()) {
                /** @var User[] $users */
                foreach($users as $user) {
                    $recipient = new MailRecipient();
                    $recipient->makeFromUser($user, $this);
                    
                    $recipients[$recipient['email']] = $recipient;
                }
                $offset += $page_size;
            }
        }
        return $recipients;
    }
    
}
