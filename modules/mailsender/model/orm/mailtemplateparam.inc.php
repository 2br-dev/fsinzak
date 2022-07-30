<?php
namespace MailSender\Model\Orm;
use \RS\Orm\Type;

/**
 * ORM объект - параметры шаблона рассылки
 * --/--
 * @property string $template_id ID шаблона
 * @property string $entity Тип связываемого объекта
 * @property string $entity_id Идентификатор связанного объекта
 * @property string $params Параметры
 * --\--
 */
class MailTemplateParam extends \RS\Orm\AbstractObject
{
    const
        ENTITY_SOURCE = 'source',
        ENTITY_FILTER = 'filter',
        ENTITY_CONTENT = 'content',
        ENTITY_ATTACHMENT = 'attachment';
        
    protected static
        $table = 'mail_template_param';
    
    function _init()
    {
        $this->getPropertyIterator()->append([
            'template_id' => new Type\Varchar([
                'description' => t('ID шаблона'),
            ]),
            'entity' => new Type\Enum([self::ENTITY_SOURCE, self::ENTITY_FILTER, self::ENTITY_CONTENT, self::ENTITY_ATTACHMENT], [
                'description' => t('Тип связываемого объекта')
            ]),
            'entity_id' => new Type\Varchar([
                'description' => t('Идентификатор связанного объекта')
            ]),
            'params' => new Type\Text([
                'description' => t('Параметры')
            ])
        ]);
    }
}