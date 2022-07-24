<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/
namespace Designer\Controller\Admin;

use Designer\Model\AtomApis\ProductApi;
use RS\Controller\Admin\Front;

/**
 * Контроллер, позволяющий работать с компонентом товар
 */
class AtomProductCtrl extends Front
{
    /**
     * @var ProductApi $api
     */
    protected $api;
    /**
     * Инициализация контроллера
     *
     * @throws \RS\Exception
     */
    function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        $this->api = new ProductApi();
    }

    /**
     * Возвращает комплектации для нужного товара
     *
     * @return \RS\Controller\Result\Standard
     * @throws \RS\Exception
     * @throws \RS\Orm\Exception
     */
    function actionGetProductById()
    {
        $product_id   = $this->request('product_id', TYPE_INTEGER, 0);
        $offer_sortn  = $this->request('offer', TYPE_INTEGER, 0);
        $photo_params = $this->request('photo', TYPE_ARRAY, []);
        $product = new \Catalog\Model\Orm\Product($product_id);
        if (!$product['id']){
            return $this->result->setSuccess(false)->addEMessage(t('Товар не найден'));
        }
        if (!$product['public']){
            return $this->result->setSuccess(false)->addEMessage(t('Товар является скрытым'));
        }
        $info = $this->api->getProductInfo($product_id, $offer_sortn, $photo_params);

        $info['title'] = htmlspecialchars_decode($info['title']);
        $info['short_description'] = htmlspecialchars_decode($info['short_description']);
        $info['description'] = htmlspecialchars_decode($info['description']);

        return $this->result->setSuccess(true)->addSection('product', $info);
    }


    /**
     *  Возвращает данные по комплектациям
     *
     * @return \RS\Controller\Result\Standard
     * @throws \RS\Exception
     */
    function actionGetOffersByProductId()
    {
        $product_id = $this->request('product_id', TYPE_INTEGER, 0);
        $product = new \Catalog\Model\Orm\Product($product_id);
        if (!$product['id']){
            return $this->result->setSuccess(true)->addEMessage(t('Товар не найден'));
        }
        $info = \ExternalApi\Model\Utils::extractOrm($product);
        if ($product->isOffersUse()) { //Если есть комплектации
            $offers = \ExternalApi\Model\Utils::extractOrmList($product['offers']['items']);
            $this->result->addSection('offers', $offers);
        }
        $info['title'] = htmlspecialchars_decode($info['title']);
        return $this->result->setSuccess(true)->addSection('product', $info);
    }
}