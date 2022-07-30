<?php

namespace MailSender\Model\Filter;

use RS\Module\AbstractModel\TreeList\AbstractTreeListIterator;
use RS\Orm\FormObject;
use RS\Orm\PropertyIterator;
use RS\Orm\Type;
use MailSender\Model\Orm\MailRecipient;

/**
 * Фильтр по группе пользователя из адресной книги
 */
class AddressBookGroup extends AbstractFilter
{
    /**
     * Возвращает название фильтра
     *
     * @return string
     */
    public function getTitle()
    {
        return t('Группа пользователя из адресной книги');
    }

    /**
     * Возвращает объект с настройками фильтра
     *
     * @return \RS\Orm\FormObject | null
     */
    public function getSettingsObject()
    {
        $form_object = new FormObject(new PropertyIterator([
            'groups' => new Type\ArrayList([
                'description' => t('Группа'),
                'list' => [['\MailSender\Model\AddressBookDirApi', 'staticSelectList']],
                'attr' => [[
                    AbstractTreeListIterator::ATTRIBUTE_MULTIPLE => true,
                ]],
                'checker' => ['chkEmpty', t('Укажите группы пользователей')]
            ])
        ]));

        $form_object->setParentObject($this);
        return $form_object;
    }

    /**
     * Возвращает true, если письмо можно направить получателю $recipient
     *
     * @param MailRecipient $recipient
     * @return bool
     */
    public function canSendToRecipient(MailRecipient $recipient)
    {
        if (!$recipient['is_system_user']) {
            return count(array_intersect(explode(',', $recipient['groups']), $this->settings['groups']));
        }
        return true;
    }
}
