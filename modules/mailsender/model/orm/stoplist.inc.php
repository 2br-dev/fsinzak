<?php
namespace MailSender\Model\Orm;
use \RS\Orm\Type;

/**
 * --/--
 * @property integer $id Уникальный идентификатор (ID)
 * @property integer $site_id ID сайта
 * @property string $email Email получателя
 * @property string $dateof Дата внесения
 * --\--
 */
class StopList extends \RS\Orm\OrmObject
{
    protected static
        $table = 'mail_stoplist';    
        
    function _init()
    {
        parent::_init()->append([
            'site_id' => new Type\CurrentSite(),
            'email' => new Type\Varchar([
                'description' => t('Email получателя'),
                'maxLength' => 150,
            ]),
            'dateof' => new Type\Datetime([
                'description' => t('Дата внесения'),
                'visible' => false
            ])
        ]);
        
        $this->addIndex(['site_id', 'email'], self::INDEX_UNIQUE);
    }
    
    function beforeWrite($flag)
    {
        if ($flag == self::INSERT_FLAG) {
            if (!$this->isModified('dateof')) {
                $this['dateof'] = date('Y-m-d H:i:s');                
            }
        }
    }
}