<?php

namespace Fsinzak\Controller\Block;

use fsinzak\Model\FaqApi;
use RS\Controller\StandartBlock;
use RS\Orm\ControllerParamObject;
use RS\Orm\Type;

/**
 * Блок-контроллер "Выбор получателя"
 */
class Faq extends StandartBlock
{
    protected static $controller_title = 'Часто задаваемые вопросы';
    protected static $controller_description = 'Отображает блок с ответами на часто задаваемые вопросы';

    protected $default_params = [
        'indexTemplate' => 'blocks/faq.tpl', //Должен быть задан у наследника
    ];

    /** @var FaqApi */
    public $api;

    function init()
    {
        $this->api = new FaqApi();
    }

    /**
     * Возвращает ORM объект, содержащий настриваемые параметры или false в случае,
     * если контроллер не поддерживает настраиваемые параметры
     *
     * @return ControllerParamObject | false
     */
    function getParamObject()
    {
        return parent::getParamObject()->appendProperty([
            'referrer' => (new Type\Varchar())
                ->setVisible(false)
                ->setDescription(t('Адрес текущей страницы')),
        ]);
    }

    /**
     * Отображение Часто задаваемые вопросы
     */
    function actionIndex()
    {
        $faq_api = new FaqApi();
        $faqs = $faq_api->setFilter('public', 1)->getList();
        $this->view->assign([
            'faqs' => $faqs,
        ]);
        return $this->result->setTemplate($this->getParam('indexTemplate'));
    }
}
