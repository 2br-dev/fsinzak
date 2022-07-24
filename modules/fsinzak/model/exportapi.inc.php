<?php
namespace Fsinzak\Model;

use Fsinzak\Model\ExportModels\PDF;
use Fsinzak\Model\ExportModels\XLSX;
use RS\Module\AbstractModel\BaseModel;

class ExportApi extends BaseModel {
    /**
     * @var PDF|XLSX $model_class
     */
    protected $model_class;

    /**
     * ExportApi constructor.
     * @param PDF|XLSX $model_class - класс модели с которой работает API
     */
    function __construct($model_class){
        $this->model_class = $model_class;
    }

    /**
     * Возвращает ссылку на файл с данными
     *
     * @param \Shop\Model\Orm\Order $order
     *
     * @return string
     */
    function getExportFile($order): string
    {
        return $this->model_class->getExportFile($order);
    }
}
