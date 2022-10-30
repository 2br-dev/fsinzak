<?php

namespace Fsinzak\Controller\Block;

use fsinzak\Model\FaqApi;
use fsinzak\Model\HowOrderApi;
use fsinzak\Model\Orm\HowOrder;
use RS\Controller\StandartBlock;
use RS\Orm\ControllerParamObject;
use RS\Orm\Type;

/**
 * Блок-контроллер
 */
class HowOrderBlock extends StandartBlock
{
    protected static $controller_title = 'Как заказать';
    protected static $controller_description = 'Отображает блок с инструкцией как Заказать';

    protected $default_params = [
        'indexTemplate' => 'blocks/howorder.tpl', //Должен быть задан у наследника
    ];

    /** @var FaqApi */
    public $api;

    function init()
    {
        $this->api = new HowOrderApi();
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
        $howorder_api = new HowOrderApi();
        $howorder = $howorder_api->setFilter('public', 1)->setOrder('number')->getList();
        $this->view->assign([
            'howorder' => $howorder,
        ]);
        return $this->result->setTemplate($this->getParam('indexTemplate'));
    }
}
