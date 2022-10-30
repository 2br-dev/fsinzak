<?php

namespace fsinzak\Model\Orm;

use RS\Orm\OrmObject;
use RS\Orm\Type;

/**
 * ORM объект
 */
class Review extends OrmObject
{
    protected static $table = 'review';

    function _init()
    {
        parent::_init()->append([
            'user_id' => new Type\Integer([
                'description' => t('Пользователь'),
                'visible' => false
            ]),
            '__url_user__' => new Type\MixedType([
                'visible' => true,
                'description' => t('Пользователь'),
                'template' => '%fsinzak%/form/review/user.tpl'
            ]),
            'site_id' => new Type\Integer([
                'description' => t('Сайт'),
                'visible' => false
            ]),
            'text' => new Type\Richtext([
                'description' => t('Текст отзыва')
            ]),
            'public' => new Type\Integer([
                'description' => t('Публиковать'),
                'CheckBoxView' => [1,0],
                'default' => 0
            ]),
            'answer' => new Type\Richtext([
                'description' => t('Ответ администратора')
            ]),
            'dateof' => new Type\Date([
                'description' => t('Дата')
            ])
        ]);
    }

    /**
     * Возвращает объект пользователя оставившего отзыв
     * @return \Users\Model\Orm\User
     */
    public function getUser()
    {
        return new \Users\Model\Orm\User($this['user_id']);
    }

    /**
     * Получает ссылку на пользователя в админ панели.
     *
     * @return false|string
     */
    function getUserAdminHref()
    {
        /**
         * @var \RS\Router\Manager $router
         */
        $router = \RS\Router\Manager::class;
        $router->getRootUrl();
        if ($this['user_id']) {
            return \RS\Router\Manager::obj()->getAdminUrl('edit', ['id' => $this['user_id']], 'users-ctrl');
        }
        return false;
    }
}
