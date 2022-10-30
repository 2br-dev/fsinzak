<?php

namespace Fsinzak\Controller\Block;

use fsinzak\Model\FaqApi;
use fsinzak\Model\FooterApi;
use fsinzak\Model\HowOrderApi;
use fsinzak\Model\Orm\Footer;
use fsinzak\Model\Orm\HowOrder;
use RS\Controller\StandartBlock;
use RS\Orm\ControllerParamObject;
use RS\Orm\Type;

/**
 * Блок-контроллер
 */
class FooterBlock extends StandartBlock
{
    protected static $controller_title = 'Подвал сайта';
    protected static $controller_description = 'Отображает блок подвал сайта';

    protected $default_params = [
        'indexTemplate' => 'blocks/footer.tpl', //Должен быть задан у наследника
    ];

    /** @var FaqApi */
    public $api;

    function init()
    {
        $this->api = new FooterApi();
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
        $footer_api = new FooterApi();
        $footer = $footer_api->setOrder('id')->getFirst();
        $this->view->assign([
            'footer' => $footer,
        ]);
        return $this->result->setTemplate($this->getParam('indexTemplate'));
    }
}
