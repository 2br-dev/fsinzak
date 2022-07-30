<?php
namespace MailSender\Model\Orm;
use \RS\Orm\Type;

/**
 * ORM объект - лог рассылки
 * --/--
 * @property integer $id Уникальный идентификатор (ID)
 * @property integer $site_id ID сайта
 * @property integer $template_id Шаблон рассылки
 * @property string $dateof Дата отправки
 * @property string $email Email получателя
 * @property string $name Имя
 * @property string $surname Фамилия
 * @property string $middle_name Отчество
 * @property string $company Компания
 * @property array $user_extra Дополнительные сведения
 * @property string $_user_extra Дополнительные сведения
 * @property integer $is_sended Флаг отправки
 * @property integer $is_system_user Это системный пользователь?
 * @property integer $user_id Пользователь
 * @property string $groups Группы
 * @property string $source_class Источник
 * @property string $uniq Дополнительная метка уникальности
 * --\--
 */
class MailRecipient extends \RS\Orm\OrmObject
{
    protected static
        $table = 'mail_recipient';
    
    function _init()
    {
        parent::_init()->append([
            'site_id' => new Type\CurrentSite(),
            'template_id' => new Type\Integer([
                'description' => t('Шаблон рассылки'),
                'list' => [['\MailSender\Model\TemplateApi','staticSelectList']],
                'maxLength' => '100',
            ]),
            'dateof' => new Type\Varchar([
                'description' => t('Дата отправки'),
            ]),
            'email' => new Type\Varchar([
                'description' => t('Email получателя'),
                'maxLength' => '100',
            ]),
            'name' => new Type\Varchar([
                'description' => t('Имя')
            ]),
            'surname' => new Type\Varchar([
                'description' => t('Фамилия')
            ]),
            'middle_name' => new Type\Varchar([
                'description' => t('Отчество')
            ]),
            'company' => new Type\Varchar([
                'description' => t('Компания')
            ]),
            'user_extra' => new Type\ArrayList([
                'description' => t('Дополнительные сведения')
            ]),
            '_user_extra' => new Type\Text([
                'description' => t('Дополнительные сведения')
            ]),
            'is_sended' => new Type\Integer([
                'default' => 0,
                'allowEmpty' => false,
                'description' => t('Флаг отправки')
            ]),
            'is_system_user' => new Type\Integer([
                'description' => t('Это системный пользователь?')
            ]),
            'user_id' => new Type\Integer([
                'description' => t('Пользователь')
            ]),
            'groups' => new Type\Varchar([
                'description' => t('Группы')
            ]),
            'source_class' => new Type\Varchar([
                'description' => t('Источник')
            ]),
            'uniq' => new Type\Varchar([
                'description' => t('Дополнительная метка уникальности'),
                'maxLength' => '100',
                'default' => ''
            ]),
        ]);
        
        $this->addIndex(['template_id', 'email', 'uniq'], self::INDEX_UNIQUE);
    }
    
    function beforeWrite($flag)
    {
        $this['_user_extra'] = serialize($this['user_extra']);
    }
    
    function afterWrite($flag)
    {
        $this['user_extra'] = @unserialize($this['user_extra']);
    }
    
    /**
    * Создает получателя рассылки из объекта пользователя
    * 
    * @param \Users\Model\Orm\User $user
    * @return bool
    */
    function makeFromUser(\Users\Model\Orm\User $user, $source = null)
    {
        $this->is_system_user = true;
        $this->user_id = $user['id'];        
        $this->email = $user['e_mail'];
        $this->name = $user['name'];
        $this->surname = $user['surname'];
        $this->middle_name = $user['midname'];
        $this->groups = implode(',', $user->getUserGroups());
        $this->company = $user['company'];
        $this->source_class = is_object($source) ? get_class($source) : $source;
        return true;
    }
    
    /**
    * Возвращает список переменных для замены в теле письма
    * 
    * @return array
    */
    function getReplaceVars()
    {
        return $this->getValues() + [
            'unsubscribe_url' => $this->getUnsubscribeUrl()
            ];
    }

    /**
     * Возвращает URL на отписку от рассылки
     *
     * @return string
     */
    function getUnsubscribeUrl()
    {
        return \RS\Router\Manager::obj()->getUrl('mailsender-front-unsubscribe', [
            'email' => $this->email,
            'sign' => \MailSender\Model\StopListApi::getUnsubscribeSign($this->email)
        ], true);
    }
    
    /**
    * Возвращает пояснение к переменным
    * 
    * @return array
    */
    function getReplaceVarsTitles()
    {
        return [
            'email' => t('E-mail получателя'),
            'name' => t('Имя получателя'),
            'surname' => t('Фамилия получателя'),
            'middle_name' => t('Отчество получателя'),
            'company' => t('Наименование компании'),
            'unsubscribe_url' => t('Ссылка на отписку от рассылки')
        ];
    }    
}
