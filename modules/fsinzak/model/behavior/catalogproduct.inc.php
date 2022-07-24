<?php
namespace Fsinzak\Model\Behavior;

use Catalog\Model\DirApi;
use Catalog\Model\Orm\Dir;
use RS\Behavior\BehaviorAbstract;

class CatalogProduct extends BehaviorAbstract
{
    /**
     * Вовзвращате есть ли ограничение 18+. Проверяет у товара или у всех родителских категорий до 1 уровня
     * @param bool $only_item - проверять только у товара
     * @return mixed|\RS\Orm\Type\AbstractType
     */
    public function getLimit18(bool $only_item = true)
    {
        /**
         * @var \Catalog\Model\Orm\Product $product
         */
        $product = $this->owner;
        if($only_item){
            return $product['limit_18'];
        }
        $dir = $product->getMainDir();
        $dir_api = new DirApi();
        $parents_id = $dir_api->getParentsId($dir['id']);

        if(!$product['limit_18']){
            foreach ($parents_id as $id){
                $parent_dir = new Dir($id);
                if($parent_dir['limit_18']){
                    return true;
                }
            }
        }else{
            return true;
        }
        return false;
    }
}
