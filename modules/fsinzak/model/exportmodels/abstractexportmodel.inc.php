<?php
namespace Fsinzak\Model\ExportModels;

abstract class AbstractExportModel{
    protected $config;
    protected $total_cnt  = 0;
    protected $total_cost = 0;
    protected $total_comission = 0;
    protected $total_comission_paysystem = 0;
    protected $total_comission_im        = 0;
    public $detalization    = ''; //Тип детализации all или colonies
    public $needed_regions  = []; //Список требуемых регионов
    public $needed_colonies = []; //Список требуемых колоний

    function __construct()
    {
        $this->config = \RS\Config\Loader::byModule($this);
    }

    /**
     * Получает ссылку на файл с данными детализации
     * @param \Shop\Model\Orm\Order $order
     *
     * @return string
     */
    abstract function getExportFile($order):string;

}
