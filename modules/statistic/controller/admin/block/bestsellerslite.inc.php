<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/
namespace Statistic\Controller\Admin\Block;

class BestsellersLite extends Bestsellers
{
    function __construct($param = [])
    {
        $param['widget'] = true;
        parent::__construct($param);
    }
    
}
